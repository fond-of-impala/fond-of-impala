<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker;

use ArrayObject;
use DateTime;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper\ItemsGrouperInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper\ConditionalAvailabilityCriteriaFilterMapperInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class AvailabilitiesChecker implements AvailabilitiesCheckerInterface
{
    /**
     * @var string
     */
    protected const ERROR_TYPE_CONDITIONAL_AVAILABILITY = 'Conditional Availability';

    /**
     * @var string
     */
    protected const MESSAGE_UNAVAILABLE_PRODUCT = 'conditional_availability_checkout_connector.product.unavailable';

    /**
     * @var int
     */
    protected const ERROR_CODE_UNAVAILABLE_PRODUCT = 4102;

    /**
     * @var string
     */
    protected const PARAMETER_PRODUCT_SKU = '%sku%';

    protected ItemsGrouperInterface $itemsGrouper;

    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade;

    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService;

    protected ConditionalAvailabilityCriteriaFilterMapperInterface $conditionalAvailabilityCriteriaFilterMapper;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper\ItemsGrouperInterface $itemsGrouper
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper\ConditionalAvailabilityCriteriaFilterMapperInterface $conditionalAvailabilityCriteriaFilterMapper
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(
        ItemsGrouperInterface $itemsGrouper,
        ConditionalAvailabilityCriteriaFilterMapperInterface $conditionalAvailabilityCriteriaFilterMapper,
        ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade,
        ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
    ) {
        $this->itemsGrouper = $itemsGrouper;
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
        $this->conditionalAvailabilityCriteriaFilterMapper = $conditionalAvailabilityCriteriaFilterMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return bool
     */
    public function check(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): bool
    {
        $isPassed = true;
        $groupedItemTransfers = $this->itemsGrouper->group($quoteTransfer);
        $groupedConditionalAvailabilityTransfers = new ArrayObject();
        $conditionalAvailabilityCriteriaFilterTransfer = $this->conditionalAvailabilityCriteriaFilterMapper->fromQuote(
            $quoteTransfer,
        );

        if ($conditionalAvailabilityCriteriaFilterTransfer !== null) {
            $skus = array_keys($groupedItemTransfers->getArrayCopy());

            $groupedConditionalAvailabilityTransfers = $this->conditionalAvailabilityFacade
                ->findGroupedConditionalAvailabilities(
                    $conditionalAvailabilityCriteriaFilterTransfer->setSkus($skus),
                );
        }

        foreach ($groupedItemTransfers as $sku => $groupedQuoteItemTransferCollection) {
            foreach ($groupedQuoteItemTransferCollection as $quoteItemTransfer) {
                $isQuoteItemAvailable = $this->isQuoteItemAvailable(
                    $quoteItemTransfer,
                    $groupedConditionalAvailabilityTransfers,
                );

                if ($isQuoteItemAvailable) {
                    continue;
                }

                $this->addErrorToCheckoutResponse($checkoutResponseTransfer, $sku);
                $isPassed = false;
            }
        }

        return $isPassed;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $quoteItemTransfer
     * @param \ArrayObject $groupedConditionalAvailabilityTransferMap
     *
     * @return bool
     */
    protected function isQuoteItemAvailable(
        ItemTransfer $quoteItemTransfer,
        ArrayObject $groupedConditionalAvailabilityTransferMap
    ): bool {
        $sku = $quoteItemTransfer->getSku();

        if (!$groupedConditionalAvailabilityTransferMap->offsetExists($sku)) {
            return false;
        }

        $concreteDeliveryDate = new DateTime($quoteItemTransfer->getConcreteDeliveryDate());
        $latestOrderDate = $this->conditionalAvailabilityService->generateLatestOrderDateByDeliveryDate($concreteDeliveryDate);
        $quantity = $quoteItemTransfer->getQuantity();

        foreach ($groupedConditionalAvailabilityTransferMap->offsetGet($sku) as $conditionalAvailabilityTransfer) {
            /** @var \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer */
            $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer
                ->getConditionalAvailabilityPeriodCollection();

            if ($conditionalAvailabilityPeriodCollectionTransfer === null) {
                continue;
            }

            $conditionalAvailabilityPeriodTransfers = $conditionalAvailabilityPeriodCollectionTransfer
                ->getConditionalAvailabilityPeriods();

            foreach ($conditionalAvailabilityPeriodTransfers as $conditionalAvailabilityPeriodTransfer) {
                $startAt = new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt());
                $endAt = new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt());
                $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

                if ($latestOrderDate < $startAt || $latestOrderDate > $endAt || $availableQuantity < $quantity) {
                    continue;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     * @param string $sku
     *
     * @return void
     */
    protected function addErrorToCheckoutResponse(CheckoutResponseTransfer $checkoutResponse, string $sku): void
    {
        $checkoutErrorTransfer = (new CheckoutErrorTransfer())
            ->setErrorCode(static::ERROR_CODE_UNAVAILABLE_PRODUCT)
            ->setMessage(static::MESSAGE_UNAVAILABLE_PRODUCT)
            ->setErrorType(static::ERROR_TYPE_CONDITIONAL_AVAILABILITY)
            ->setParameters([
                static::PARAMETER_PRODUCT_SKU => $sku,
            ]);

        $checkoutResponse
            ->addError($checkoutErrorTransfer)
            ->setIsSuccess(false);
    }
}
