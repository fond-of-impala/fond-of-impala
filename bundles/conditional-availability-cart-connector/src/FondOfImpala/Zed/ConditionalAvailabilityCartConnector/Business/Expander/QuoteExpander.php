<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use ArrayObject;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\ConcreteDeliveryDateGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\EarliestDeliveryDateGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityReducerInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    /**
     * @var string
     */
    protected const DELIVERY_DATE_FORMAT = 'Y-m-d';

    protected ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader;

    protected ConditionalAvailabilityReducerInterface $conditionalAvailabilityReducer;

    protected EarliestDeliveryDateGeneratorInterface $earliestDeliveryDateGenerator;

    protected ConcreteDeliveryDateGeneratorInterface $concreteDeliveryDateGenerator;

    protected MessageGeneratorInterface $messageGenerator;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityReducerInterface $conditionalAvailabilityReducer
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\EarliestDeliveryDateGeneratorInterface $earliestDeliveryDateGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\ConcreteDeliveryDateGeneratorInterface $concreteDeliveryDateGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface $messageGenerator
     */
    public function __construct(
        ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader,
        ConditionalAvailabilityReducerInterface $conditionalAvailabilityReducer,
        EarliestDeliveryDateGeneratorInterface $earliestDeliveryDateGenerator,
        ConcreteDeliveryDateGeneratorInterface $concreteDeliveryDateGenerator,
        MessageGeneratorInterface $messageGenerator
    ) {
        $this->conditionalAvailabilityReader = $conditionalAvailabilityReader;
        $this->conditionalAvailabilityReducer = $conditionalAvailabilityReducer;
        $this->earliestDeliveryDateGenerator = $earliestDeliveryDateGenerator;
        $this->concreteDeliveryDateGenerator = $concreteDeliveryDateGenerator;
        $this->messageGenerator = $messageGenerator;
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
            $deliveryDate = $itemTransfer->getDeliveryDate();
            $concreteDeliveryDate = $itemTransfer->getConcreteDeliveryDate();
            $deliveryDates[$deliveryDate] = $deliveryDate;

            if ($concreteDeliveryDate === null) {
                continue;
            }

            $concreteDeliveryDates[$concreteDeliveryDate] = $concreteDeliveryDate;
        }

        $quoteTransfer->setDeliveryDates(array_values($deliveryDates))
            ->setConcreteDeliveryDates(array_values($concreteDeliveryDates));

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
        $sku = $itemTransfer->getSku();

        if (
            !$groupedConditionalAvailabilities->offsetExists($sku)
            || $groupedConditionalAvailabilities->offsetGet($sku)->count() !== 1
        ) {
            return $itemTransfer->addValidationMessage(
                $this->messageGenerator->createNotAvailableForEarliestDeliveryDateMessage(),
            );
        }

        $conditionalAvailabilityTransfer = $groupedConditionalAvailabilities->offsetGet($sku)->offsetGet(0);
        $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection();

        if (
            $conditionalAvailabilityPeriodCollectionTransfer === null
        ) {
            return $itemTransfer->addValidationMessage(
                $this->messageGenerator->createNotAvailableForEarliestDeliveryDateMessage(),
            );
        }

        $earliestDeliveryDate = $this->earliestDeliveryDateGenerator->generateByItemAndConditionalAvailabilityPeriods(
            $itemTransfer,
            $conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods(),
        );

        if ($earliestDeliveryDate === null) {
            return $itemTransfer->addValidationMessage(
                $this->messageGenerator->createNotAvailableForGivenQytMessage(),
            );
        }

        $this->conditionalAvailabilityReducer->reduce($conditionalAvailabilityTransfer, $itemTransfer);

        return $itemTransfer->setDeliveryDate(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE)
            ->setConcreteDeliveryDate($earliestDeliveryDate->format(static::DELIVERY_DATE_FORMAT));
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

        if (
            !$groupedConditionalAvailabilities->offsetExists($sku)
            || $groupedConditionalAvailabilities->offsetGet($sku)->count() !== 1
        ) {
            return $itemTransfer->addValidationMessage(
                $this->messageGenerator->createNotAvailableForGivenDeliveryDateMessage(),
            );
        }

        $conditionalAvailabilityTransfer = $groupedConditionalAvailabilities->offsetGet($sku)->offsetGet(0);
        $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection();

        if ($conditionalAvailabilityPeriodCollectionTransfer === null) {
            return $itemTransfer->addValidationMessage(
                $this->messageGenerator->createNotAvailableForGivenDeliveryDateMessage(),
            );
        }

        $concreteDeliveryDate = $this->concreteDeliveryDateGenerator->generateByItemAndConditionalAvailabilityPeriods(
            $itemTransfer,
            $conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods(),
        );

        if ($concreteDeliveryDate === null) {
            return $itemTransfer->addValidationMessage($this->messageGenerator->createNotAvailableForGivenQytMessage());
        }

        $this->conditionalAvailabilityReducer->reduce($conditionalAvailabilityTransfer, $itemTransfer);

        return $itemTransfer->setDeliveryDate($concreteDeliveryDate->format(static::DELIVERY_DATE_FORMAT))
            ->setConcreteDeliveryDate($concreteDeliveryDate->format(static::DELIVERY_DATE_FORMAT));
    }
}
