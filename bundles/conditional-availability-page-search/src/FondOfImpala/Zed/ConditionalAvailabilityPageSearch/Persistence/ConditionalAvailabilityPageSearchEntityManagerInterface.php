<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;

interface ConditionalAvailabilityPageSearchEntityManagerInterface
{
    /**
     * @param array $conditionalAvailabilityIds
     *
     * @return void
     */
    public function deleteConditionalAvailabilityPeriodSearchPagesByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): void;

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return void
     */
    public function createConditionalAvailabilityPeriodPageSearch(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): void;
}
