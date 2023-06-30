<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use ArrayObject;
use DateTime;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use function array_unique;

class ConditionalAvailabilityExpander implements ConditionalAvailabilityExpanderInterface
{
    /**
     * @var string
     */
    protected const DELIVERY_DATE_FORMAT = 'Y-m-d';

    /**
     * @var string
     */
    protected const MESSAGE_TYPE_ERROR = 'error';

    /**
     * @var string
     */
    protected const MESSAGE_NOT_AVAILABLE_FOR_GIVEN_DELIVERY_DATE = 'conditional_availability_cart_connector.not_available_for_given_delivery_date';

    /**
     * @var string
     */
    protected const MESSAGE_NOT_AVAILABLE_FOR_EARLIEST_DELIVERY_DATE = 'conditional_availability_cart_connector.not_available_for_earliest_delivery_date';

    /**
     * @var string
     */
    protected const MESSAGE_NOT_AVAILABLE_FOR_GIVEN_QTY = 'conditional_availability_cart_connector.not_available_for_given_qty';

    protected ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader;

    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(
        ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader,
        ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
    ) {
        $this->conditionalAvailabilityReader = $conditionalAvailabilityReader;
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $deliveryDates = [];
        $concreteDeliveryDates = [];
        $groupedConditionalAvailabilities = $this->conditionalAvailabilityReader->getGroupedByQuote($quoteTransfer);

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $itemTransfer = $this->expandItem($itemTransfer, $groupedConditionalAvailabilities);
            $deliveryDates[] = $itemTransfer->getDeliveryDate();

            if ($itemTransfer->getConcreteDeliveryDate() === null) {
                continue;
            }

            $concreteDeliveryDates[] = $itemTransfer->getConcreteDeliveryDate();
        }

        $quoteTransfer->setDeliveryDates($this->createUniqueDates($deliveryDates))
            ->setConcreteDeliveryDates($this->createUniqueDates($concreteDeliveryDates));

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItem(
        ItemTransfer $itemTransfer,
        ArrayObject $groupedConditionalAvailabilities
    ): ItemTransfer {
        if ($itemTransfer->getDeliveryDate() === ConditionalAvailabilityConstants::KEY_EARLIEST_DATE) {
            return $this->expandItemWithEarliestDeliveryDate($itemTransfer, $groupedConditionalAvailabilities);
        }

        return $this->expandItemWithConcreteDeliveryDate($itemTransfer, $groupedConditionalAvailabilities);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItemWithEarliestDeliveryDate(
        ItemTransfer $itemTransfer,
        ArrayObject $groupedConditionalAvailabilities
    ): ItemTransfer {
        $today = new DateTime();
        $earliestDeliveryDate = $this->conditionalAvailabilityService->generateEarliestDeliveryDate();
        $sku = $itemTransfer->getSku();
        $quantity = $itemTransfer->getQuantity();

        if (!$groupedConditionalAvailabilities->offsetExists($sku)) {
            return $itemTransfer->addValidationMessage($this->createNotAvailableForEarliestDeliveryDateMessage());
        }

        foreach ($groupedConditionalAvailabilities->offsetGet($sku) as $conditionalAvailability) {
            $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailability->getConditionalAvailabilityPeriodCollection();

            if ($conditionalAvailabilityPeriodCollectionTransfer === null) {
                return $itemTransfer->addValidationMessage($this->createNotAvailableForEarliestDeliveryDateMessage());
            }

            foreach ($conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods() as $conditionalAvailabilityPeriodTransfer) {
                $startAt = new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt());
                $endAt = new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt());
                $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

                if ($today > $endAt || $availableQuantity <= 0) {
                    continue;
                }

                if ($availableQuantity < $quantity) {
                    return $itemTransfer->addValidationMessage($this->createNotAvailableForGivenQytMessage());
                }

                $concreteDeliveryDate = $earliestDeliveryDate;

                if ($startAt > $today) {
                    $concreteDeliveryDate = $this->conditionalAvailabilityService
                        ->generateEarliestDeliveryDateByDateTime($startAt);
                }

                return $itemTransfer->setDeliveryDate(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE)
                    ->setConcreteDeliveryDate($concreteDeliveryDate->format(static::DELIVERY_DATE_FORMAT));
            }
        }

        return $itemTransfer->addValidationMessage($this->createNotAvailableForGivenQytMessage());
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject $groupedConditionalAvailabilities
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItemWithConcreteDeliveryDate(
        ItemTransfer $itemTransfer,
        ArrayObject $groupedConditionalAvailabilities
    ): ItemTransfer {
        $sku = $itemTransfer->getSku();
        $quantity = $itemTransfer->getQuantity();
        $concreteDeliveryDate = new DateTime($itemTransfer->getDeliveryDate());
        $latestOrderDate = $this->conditionalAvailabilityService->generateLatestOrderDateByDeliveryDate(
            $concreteDeliveryDate,
        );

        if (!$groupedConditionalAvailabilities->offsetExists($sku)) {
            return $itemTransfer->addValidationMessage($this->createNotAvailableForGivenDeliveryDateMessage());
        }

        foreach ($groupedConditionalAvailabilities->offsetGet($sku) as $conditionalAvailability) {
            $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailability->getConditionalAvailabilityPeriodCollection();

            if ($conditionalAvailabilityPeriodCollectionTransfer === null) {
                return $itemTransfer->addValidationMessage($this->createNotAvailableForGivenDeliveryDateMessage());
            }

            foreach ($conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods() as $conditionalAvailabilityPeriodTransfer) {
                $startAt = new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt());
                $endAt = new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt());
                $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

                if ($latestOrderDate < $startAt || $latestOrderDate > $endAt || $availableQuantity < $quantity) {
                    continue;
                }

                return $itemTransfer->setDeliveryDate($concreteDeliveryDate->format(static::DELIVERY_DATE_FORMAT))
                    ->setConcreteDeliveryDate($concreteDeliveryDate->format(static::DELIVERY_DATE_FORMAT));
            }
        }

        return $itemTransfer->addValidationMessage($this->createNotAvailableForGivenQytMessage());
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createNotAvailableForGivenDeliveryDateMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::MESSAGE_TYPE_ERROR)
            ->setValue(static::MESSAGE_NOT_AVAILABLE_FOR_GIVEN_DELIVERY_DATE);

        return $messageTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createNotAvailableForEarliestDeliveryDateMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::MESSAGE_TYPE_ERROR)
            ->setValue(static::MESSAGE_NOT_AVAILABLE_FOR_EARLIEST_DELIVERY_DATE);

        return $messageTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createNotAvailableForGivenQytMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::MESSAGE_TYPE_ERROR)
            ->setValue(static::MESSAGE_NOT_AVAILABLE_FOR_GIVEN_QTY);

        return $messageTransfer;
    }

    /**
     * @param array $dates
     *
     * @return array
     */
    protected function createUniqueDates(array $dates): array
    {
        return array_values(array_unique($dates));
    }
}
