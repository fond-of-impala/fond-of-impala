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
    public function findConcreteProductIdsToTrigger(): array;
}
