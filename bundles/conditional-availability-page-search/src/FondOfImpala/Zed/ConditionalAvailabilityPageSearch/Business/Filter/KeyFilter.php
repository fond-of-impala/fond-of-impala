<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter;

use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityPeriodTableMap;

class KeyFilter implements KeyFilterInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return array<string>
     */
    public function filterFromEventEntities(array $eventEntityTransfers): array
    {
        $keys = [];

        foreach ($eventEntityTransfers as $eventEntityTransfer) {
            $additionalValues = $eventEntityTransfer->getAdditionalValues();

            if (!isset($additionalValues[FoiConditionalAvailabilityPeriodTableMap::COL_KEY])) {
                continue;
            }

            $keys[] = $additionalValues[FoiConditionalAvailabilityPeriodTableMap::COL_KEY];
        }

        return array_values(array_unique($keys));
    }
}
