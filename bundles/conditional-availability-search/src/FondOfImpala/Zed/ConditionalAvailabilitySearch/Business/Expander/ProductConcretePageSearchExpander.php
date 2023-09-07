<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander;

use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;

class ProductConcretePageSearchExpander implements ProductConcretePageSearchExpanderInterface
{
    /**
     * @var \Spryker\Zed\ProductListSearch\Dependency\Facade\ProductListSearchToProductListFacadeInterface
     */
    protected $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(
        ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
    ) {
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expandProductConcretePageSearchTransferWithStockStatus(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer {
        $productConcretePageSearchTransfer->requireFkProduct();

        $conditionalAvailabilityCriteriaFilterTransfer = (new ConditionalAvailabilityCriteriaFilterTransfer())
            ->setSkus([$productConcretePageSearchTransfer->getSku()]);

        $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityFacade
            ->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);

        if (!$conditionalAvailabilityCollectionTransfer) {
            return $productConcretePageSearchTransfer;
        }

        $stockStatus = [];
        foreach ($conditionalAvailabilityCollectionTransfer->getConditionalAvailabilities() as $conditionalAvailability) {
            $stockStatus[] = $this->getStockStatus($conditionalAvailability);
        }

        return $productConcretePageSearchTransfer->setStockStatus($stockStatus);
    }

    /**
     * @param ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     * @return StockStatusTransfer
     */
    protected function getStockStatus(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): string
    {
        $conditionalAvailabilityPeriods =
            $this->sortConditionalAvailabilityPeriodCollection(
                $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection()
            );

        foreach ($conditionalAvailabilityPeriods as $timestamp => $conditionalAvailabilityPeriodTransfer) {
            /** @var \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer */
            if ($conditionalAvailabilityPeriodTransfer->getQuantity() <= 0) {
                return $conditionalAvailabilityTransfer->getChannel() .'-'. 1;
                continue;
            }

            if ($conditionalAvailabilityPeriodTransfer->getQuantity() > 0) {
                return $conditionalAvailabilityTransfer->getChannel() .'-'. 2;
                continue;
            }
        }

        return '';
    }

    protected function sortConditionalAvailabilityPeriodCollection(
        ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
    ): array
    {
        $conditionalAvailabilityPeriods = [];

        foreach ($conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods() as $conditionalAvailabilityPeriodTransfer) {
            $conditionalAvailabilityPeriods[$conditionalAvailabilityPeriodTransfer->getStartAt()] = $conditionalAvailabilityPeriodTransfer;
        }

        ksort($conditionalAvailabilityPeriods);

        return $conditionalAvailabilityPeriods;
    }

}
