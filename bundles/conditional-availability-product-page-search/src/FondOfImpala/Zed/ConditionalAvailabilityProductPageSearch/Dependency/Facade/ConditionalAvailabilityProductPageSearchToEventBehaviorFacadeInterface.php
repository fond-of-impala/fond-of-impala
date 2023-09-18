<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

interface ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventTransfers
     *
     * @return array<int>
     */
    public function getEventTransferIds(array $eventTransfers): array;
}
