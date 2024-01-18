<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
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
        $productAbstractIds = $productPageLoadTransfer->getProductAbstractIds();
        $payloadTransfers = $productPageLoadTransfer->getPayloadTransfers();

        if (count($productAbstractIds) === 0 || count($payloadTransfers) === 0) {
            return $productPageLoadTransfer;
        }

        $groupedConditionalAvailabilityTransfers = $this->conditionalAvailabilityFacade
            ->findGroupedConditionalAvailabilitiesByProductAbstractIds($productAbstractIds);

        foreach ($payloadTransfers as $payloadTransfer) {
            if (!$payloadTransfer instanceof ProductPayloadTransfer) {
                continue;
            }

            $idProductAbstract = (string)$payloadTransfer->getIdProductAbstract();

            if (
                $idProductAbstract === ''
                || !$groupedConditionalAvailabilityTransfers->offsetExists($idProductAbstract)
            ) {
                continue;
            }

            $stockStatus = [];
            $groupedRawValues = $this->getGroupedRawValuesByConditionalAvailabilities(
                $groupedConditionalAvailabilityTransfers->offsetGet($idProductAbstract),
            );

            if (count($groupedRawValues) === 0) {
                continue;
            }

            foreach ($groupedRawValues as $channel => $stockStatusRawValue) {
                $stockStatus[] = $this->stockStatusGenerator->generateByRawValueAndChannel(
                    $stockStatusRawValue,
                    $channel,
                );
            }

            $payloadTransfer->setStockStatus($stockStatus);
        }

        return $productPageLoadTransfer->setPayloadTransfers($payloadTransfers);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer> $conditionalAvailabilityTransfers
     *
     * @return array<string, int>
     */
    protected function getGroupedRawValuesByConditionalAvailabilities(
        ArrayObject $conditionalAvailabilityTransfers
    ): array {
        $groupedRawValues = [];

        foreach ($conditionalAvailabilityTransfers as $conditionalAvailabilityTransfer) {
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
