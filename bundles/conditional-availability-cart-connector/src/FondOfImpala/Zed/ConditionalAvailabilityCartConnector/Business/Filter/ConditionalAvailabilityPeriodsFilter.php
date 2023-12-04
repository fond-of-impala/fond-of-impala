<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

class ConditionalAvailabilityPeriodsFilter implements ConditionalAvailabilityPeriodsFilterInterface
{
    /**
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>|null
     */
    public function filterFromGroupedConditionalAvailabilitiesByItem(
        ArrayObject $groupedConditionalAvailabilities,
        ItemTransfer $itemTransfer
    ): ?ArrayObject {
        $sku = $itemTransfer->getSku();

        if (
            !$groupedConditionalAvailabilities->offsetExists($sku)
            || $groupedConditionalAvailabilities->offsetGet($sku)->count() !== 1
        ) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer */
        $conditionalAvailabilityTransfer = $groupedConditionalAvailabilities->offsetGet($sku)->offsetGet(0);
        /** @var \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer */
        $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection();

        if ($conditionalAvailabilityPeriodCollectionTransfer === null) {
            return null;
        }

        return $conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods();
    }
}
