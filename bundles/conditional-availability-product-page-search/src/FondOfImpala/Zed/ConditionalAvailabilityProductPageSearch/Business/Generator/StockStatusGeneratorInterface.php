<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;

interface StockStatusGeneratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
     *
     * @return int
     */
    public function generateRawValueByConditionalAvailabilityPeriodCollection(
        ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
    ): int;

    /**
     * @param int $rawValue
     * @param string $channel
     *
     * @return string
     */
    public function generateByRawValueAndChannel(int $rawValue, string $channel): string;
}
