<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;

interface ConditionalAvailabilityPeriodPageDataExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands the provided ConditionalAvailabilityPeriodPageSearch transfer object's data by reference.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    public function expand(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer;
}
