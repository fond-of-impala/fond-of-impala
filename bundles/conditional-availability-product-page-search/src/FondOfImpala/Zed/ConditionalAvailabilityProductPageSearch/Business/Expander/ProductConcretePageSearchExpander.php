<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;

class ProductConcretePageSearchExpander implements ProductConcretePageSearchExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(
        ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
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

        $stockStatus = [];
        foreach ($conditionalAvailabilityCollectionTransfer->getConditionalAvailabilities() as $conditionalAvailability) {
            $stockStatus[] = $this->getStockStatus($conditionalAvailability);
        }

        return $productConcretePageSearchTransfer->setStockStatus($stockStatus);
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return string
     */
    protected function getStockStatus(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): string
    {
        $conditionalAvailabilityPeriods =
            $this->sortConditionalAvailabilityPeriodCollection(
                $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection(),
            );

        return $conditionalAvailabilityTransfer->getChannel() .
            '-' . $this->getStockStatusValue($conditionalAvailabilityPeriods);
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
     *
     * @return array<string, \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>
     */
    protected function sortConditionalAvailabilityPeriodCollection(
        ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
    ): array {
        $conditionalAvailabilityPeriods = [];

        foreach ($conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods() as $conditionalAvailabilityPeriodTransfer) {
            $conditionalAvailabilityPeriods[$conditionalAvailabilityPeriodTransfer->getStartAt()] = $conditionalAvailabilityPeriodTransfer;
        }

        ksort($conditionalAvailabilityPeriods);

        return $conditionalAvailabilityPeriods;
    }

    /**
     * @param array<string, \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer> $conditionalAvailabilityPeriods
     *
     * @return int
     */
    protected function getStockStatusValue(array $conditionalAvailabilityPeriods): int
    {
        /** @var \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer */
        $conditionalAvailabilityPeriodTransfer = array_shift($conditionalAvailabilityPeriods);

        if ($conditionalAvailabilityPeriodTransfer->getQuantity() > 0) {
            return ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK;
        }

        foreach ($conditionalAvailabilityPeriods as $conditionalAvailabilityPeriodTransfer) {
            /** @var \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer */
            if ($conditionalAvailabilityPeriodTransfer->getQuantity() > 0) {
                return ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_LATER_IN_STOCK;
            }
        }

        return ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_OUT_OF_STOCK;
    }
}
