<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;

class ProductPageLoadExpander implements ProductPageLoadExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface
     */
    protected StockStatusGeneratorInterface $stockStatusGenerator;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface $stockStatusGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(
        StockStatusGeneratorInterface $stockStatusGenerator,
        ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade,
        ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
    ) {
        $this->productFacade = $productFacade;
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
        $this->stockStatusGenerator = $stockStatusGenerator;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expand(ProductPageLoadTransfer $productPageLoadTransfer): ProductPageLoadTransfer
    {
        $updatedPayloadTransfers = $this->updatePayloadTransfers($productPageLoadTransfer->getPayloadTransfers());

        $productPageLoadTransfer->setPayloadTransfers($updatedPayloadTransfers);

        return $productPageLoadTransfer;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductPayloadTransfer> $payloadTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductPayloadTransfer>
     */
    protected function updatePayloadTransfers(array $payloadTransfers): array
    {
        foreach ($payloadTransfers as $payloadTransfer) {
            $groupedStockStatusRawValues = [];
            $stockStatus = [];

            if (
                !$payloadTransfer instanceof ProductPayloadTransfer
                || $payloadTransfer->getIdProductAbstract() === null
            ) {
                continue;
            }

            $productConcreteTransfers = $this->productFacade->getConcreteProductsByAbstractProductId(
                $payloadTransfer->getIdProductAbstract(),
            );

            foreach ($productConcreteTransfers as $productConcreteTransfer) {
                $conditionalAvailabilityCriteriaFilterTransfer = (new ConditionalAvailabilityCriteriaFilterTransfer())
                    ->setSkus([$productConcreteTransfer->getSku()]);

                $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityFacade
                    ->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);

                $currentGroupedStockStatusRawValues = $this->getGroupedStockStatusRawValuesByConditionalAvailabilityCollection(
                    $conditionalAvailabilityCollectionTransfer,
                );

                $groupedStockStatusRawValues = $this->combineGroupedStockStatusRawValues(
                    $groupedStockStatusRawValues,
                    $currentGroupedStockStatusRawValues,
                );
            }

            foreach ($groupedStockStatusRawValues as $channel => $stockStatusRawValue) {
                $stockStatus[] = $this->stockStatusGenerator->generateByRawValueAndChannel(
                    $stockStatusRawValue,
                    $channel,
                );
            }

            $payloadTransfer->setStockStatus($stockStatus);
        }

        return $payloadTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
     *
     * @return array<string, int>
     */
    protected function getGroupedStockStatusRawValuesByConditionalAvailabilityCollection(
        ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
    ): array {
        $productConcreteStockStatus = [];
        $conditionalAvailabilityTransfers = $conditionalAvailabilityCollectionTransfer->getConditionalAvailabilities();

        foreach ($conditionalAvailabilityTransfers as $conditionalAvailabilityTransfer) {
            $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer
                ->getConditionalAvailabilityPeriodCollection();

            if ($conditionalAvailabilityPeriodCollectionTransfer === null) {
                continue;
            }

            $productConcreteStockStatus[$conditionalAvailabilityTransfer->getChannel()]
                = $this->stockStatusGenerator->generateRawValueByConditionalAvailabilityPeriodCollection(
                    $conditionalAvailabilityPeriodCollectionTransfer,
                );
        }

        return $productConcreteStockStatus;
    }

    /**
     * @param array<string, int> $aGroupedStockStatusRawValues
     * @param array<string, int> $bGroupedStockStatusRawValues
     *
     * @return array<string, int>
     */
    protected function combineGroupedStockStatusRawValues(
        array $aGroupedStockStatusRawValues,
        array $bGroupedStockStatusRawValues
    ): array {
        foreach ($bGroupedStockStatusRawValues as $channel => $productConcreteStockStatusValue) {
            if (!array_key_exists($channel, $aGroupedStockStatusRawValues)) {
                $aGroupedStockStatusRawValues[$channel] = $productConcreteStockStatusValue;

                continue;
            }

            if ($aGroupedStockStatusRawValues[$channel] >= $productConcreteStockStatusValue) {
                continue;
            }

            $aGroupedStockStatusRawValues[$channel] = $productConcreteStockStatusValue;
        }

        return $aGroupedStockStatusRawValues;
    }
}
