<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;

interface ConditionalAvailabilityPageSearchEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return void
     */
    public function persistConditionalAvailabilityPeriodPageSearch(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): void;

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function deleteConditionalAvailabilityPeriodSearchPagesByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): void;

    /**
     * @param array<string> $keys
     *
     * @return void
     */
    public function deleteConditionalAvailabilityPeriodSearchPagesByKeys(
        array $keys
    ): void;
}
