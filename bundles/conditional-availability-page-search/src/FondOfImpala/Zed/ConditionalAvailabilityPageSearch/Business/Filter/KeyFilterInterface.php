<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter;

interface KeyFilterInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return array<string>
     */
    public function filterFromEventEntities(array $eventEntityTransfers): array;
}
