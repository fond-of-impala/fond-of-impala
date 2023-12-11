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
    public function findProductConcreteIdsToTrigger(): array;

    /**
     * @return array<int>
     */
    public function findProductConcreteIdsForDeltaTrigger(): array;
}
