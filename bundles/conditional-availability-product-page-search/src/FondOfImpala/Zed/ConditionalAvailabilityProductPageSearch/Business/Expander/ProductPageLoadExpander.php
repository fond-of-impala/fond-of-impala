<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;

class ProductPageLoadExpander implements ProductPageLoadExpanderInterface
{
    protected StockStatusGeneratorInterface $stockStatusGenerator;

    protected ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface $stockStatusGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(
        StockStatusGeneratorInterface $stockStatusGenerator,
        ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
    ) {
        $this->stockStatusGenerator = $stockStatusGenerator;
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expand(ProductPageLoadTransfer $productPageLoadTransfer): ProductPageLoadTransfer
    {
        $updatedPayloadTransfers = $this->expandPayloadTransfers($productPageLoadTransfer->getPayloadTransfers());

        $productPageLoadTransfer->setPayloadTransfers($updatedPayloadTransfers);

        return $productPageLoadTransfer;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductPayloadTransfer> $payloadTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductPayloadTransfer>
     */
    protected function expandPayloadTransfers(array $payloadTransfers): array
    {
        foreach ($payloadTransfers as $payloadTransfer) {
            if (
                !$payloadTransfer instanceof ProductPayloadTransfer
                || $payloadTransfer->getIdProductAbstract() === null
            ) {
                continue;
            }

            $stockStatus = [];

            $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityFacade
                ->findConditionalAvailabilitiesByProductAbstractIds([$payloadTransfer->getIdProductAbstract()]);

            $groupedRawValues = $this->getGroupedRawValuesByConditionalAvailabilityCollection(
                $conditionalAvailabilityCollectionTransfer,
            );

            foreach ($groupedRawValues as $channel => $stockStatusRawValue) {
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
    protected function getGroupedRawValuesByConditionalAvailabilityCollection(
        ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransfer
    ): array {
        $groupedRawValues = [];

        foreach ($conditionalAvailabilityCollectionTransfer->getConditionalAvailabilities() as $conditionalAvailabilityTransfer) {
            $channel = $conditionalAvailabilityTransfer->getChannel();
            $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer
                ->getConditionalAvailabilityPeriodCollection();

            if ($channel === null || $conditionalAvailabilityPeriodCollectionTransfer === null) {
                continue;
            }

            $rawValue = $this->stockStatusGenerator->generateRawValueByConditionalAvailabilityPeriodCollection(
                $conditionalAvailabilityPeriodCollectionTransfer,
            );

            if (array_key_exists($channel, $groupedRawValues) && $groupedRawValues[$channel] >= $rawValue) {
                continue;
            }

            $groupedRawValues[$channel] = $rawValue;
        }

        return $groupedRawValues;
    }
}
