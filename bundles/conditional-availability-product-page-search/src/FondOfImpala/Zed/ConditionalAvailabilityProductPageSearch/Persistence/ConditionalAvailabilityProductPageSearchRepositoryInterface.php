<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence;

/**
 * @codeCoverageIgnore
 */
interface ConditionalAvailabilityProductPageSearchRepositoryInterface
{
    /**
     * @return array<int>
     */
    public function findProductAbstractIdsToTrigger(): array;

    /**
     * @return array<int>
     */
    public function findProductAbstractIdsForDeltaTrigger(): array;
}
