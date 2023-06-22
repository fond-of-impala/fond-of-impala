<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

interface RestConditionalAvailabilityPeriodMapperPluginInterface
{
    /**
     * Specification:
     * - Maps PeriodData to RestConditionalAvailabilityPeriodTransfer.
     *
     * @api
     *
     * @param array $periodData
     * @param \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
     *
     * @return \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer
     */
    public function mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
        array $periodData,
        RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
    ): RestConditionalAvailabilityPeriodTransfer;
}
