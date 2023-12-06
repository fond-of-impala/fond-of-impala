<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter;

class IdConditionalAvailabilityFilter implements IdConditionalAvailabilityFilterInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return array<int>
     */
    public function filterFromEventEntities(array $eventEntityTransfers): array
    {
        $conditionalAvailabilityIds = [];

        foreach ($eventEntityTransfers as $eventEntityTransfer) {
            $idConditionalAvailability = $eventEntityTransfer->getId();

            if ($idConditionalAvailability === null) {
                continue;
            }

            $conditionalAvailabilityIds[] = $idConditionalAvailability;
        }

        return array_values(array_unique($conditionalAvailabilityIds));
    }
}
