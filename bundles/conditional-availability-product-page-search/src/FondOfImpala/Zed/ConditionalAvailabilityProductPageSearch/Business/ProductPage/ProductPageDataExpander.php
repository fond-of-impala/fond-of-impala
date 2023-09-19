<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ProductPage;

use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;

class ProductPageDataExpander implements ProductPageDataExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(
        ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade,
        ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
    ) {
        $this->productFacade = $productFacade;
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $productPageLoadTransfer): ProductPageLoadTransfer
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
        /** @var \Generated\Shared\Transfer\ProductPayloadTransfer $payloadTransfer */
        foreach ($payloadTransfers as $payloadTransfer) {
            $productAbstractStockStatus = [];
            $stockStatus = [];
            $productConcreteTransfers = $this->productFacade->getConcreteProductsByAbstractProductId(
                $payloadTransfer->getIdProductAbstract(),
            );

            /** @var \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer */
            foreach ($productConcreteTransfers as $productConcreteTransfer) {
                $conditionalAvailabilityCriteriaFilterTransfer = (new ConditionalAvailabilityCriteriaFilterTransfer())
                    ->setSkus([$productConcreteTransfer->getSku()]);

                $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityFacade
                    ->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);

                $productAbstractStockStatus =
                    $this->buildProductAbstractStockStatus(
                        $productAbstractStockStatus,
                        $this->getProductConcreteStockStatus($conditionalAvailabilityCollectionTransfer),
                    );
            }

            foreach ($productAbstractStockStatus as $channel => $stockStatusValue) {
                $stockStatus[] = $channel . '-' . $stockStatusValue;
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
    protected function getProductConcreteStockStatus(
        ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
    ): array {
        $productConcreteStockStatus = [];

        foreach ($conditionalAvailabilityCollectionTransfer->getConditionalAvailabilities() as $conditionalAvailabilityTransfer) {
            $conditionalAvailabilityPeriods =
                $this->sortConditionalAvailabilityPeriodCollection(
                    $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection(),
                );

            $productConcreteStockStatus[$conditionalAvailabilityTransfer->getChannel()]
                = $this->getStockStatusValue($conditionalAvailabilityPeriods);
        }

        return $productConcreteStockStatus;
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

    /**
     * @param array<string, int> $productAbstractStockStatus
     * @param array<string, int> $productConcretesStockStatus
     *
     * @return array<string, int>
     */
    protected function buildProductAbstractStockStatus(
        array $productAbstractStockStatus,
        array $productConcretesStockStatus
    ): array {
        foreach ($productConcretesStockStatus as $channel => $productConcreteStockStatusValue) {
            if (!array_key_exists($channel, $productAbstractStockStatus)) {
                $productAbstractStockStatus[$channel] = $productConcreteStockStatusValue;

                continue;
            }

            if ($productAbstractStockStatus[$channel] >= $productConcreteStockStatusValue) {
                continue;
            }

            $productAbstractStockStatus[$channel] = $productConcreteStockStatusValue;
        }

        return $productAbstractStockStatus;
    }
}
