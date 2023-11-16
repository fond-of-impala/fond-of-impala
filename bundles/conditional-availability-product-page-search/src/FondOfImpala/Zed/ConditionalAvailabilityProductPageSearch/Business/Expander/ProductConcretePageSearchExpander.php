<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;

class ProductConcretePageSearchExpander implements ProductConcretePageSearchExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface
     */
    protected StockStatusGeneratorInterface $stockStatusGenerator;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface $stockStatusGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(
        StockStatusGeneratorInterface $stockStatusGenerator,
        ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
    ) {
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
        $this->stockStatusGenerator = $stockStatusGenerator;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expand(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer {
        $productConcretePageSearchTransfer->requireFkProduct();

        $conditionalAvailabilityCriteriaFilterTransfer = (new ConditionalAvailabilityCriteriaFilterTransfer())
            ->setSkus([$productConcretePageSearchTransfer->getSku()]);

        $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityFacade
            ->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);

        $stockStatus = [];

        $conditionalAvailabilityTransfers = $conditionalAvailabilityCollectionTransfer->getConditionalAvailabilities();

        foreach ($conditionalAvailabilityTransfers as $conditionalAvailabilityTransfer) {
            $channel = $conditionalAvailabilityTransfer->getChannel();
            $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer
                ->getConditionalAvailabilityPeriodCollection();

            if ($channel === null || $conditionalAvailabilityPeriodCollectionTransfer === null) {
                continue;
            }

            $stockStatusRawValue = $this->stockStatusGenerator->generateRawValueByConditionalAvailabilityPeriodCollection(
                $conditionalAvailabilityPeriodCollectionTransfer,
            );

            $stockStatus[] = $this->stockStatusGenerator->generateByRawValueAndChannel($stockStatusRawValue, $channel);
        }

        return $productConcretePageSearchTransfer->setStockStatus($stockStatus);
    }
}
