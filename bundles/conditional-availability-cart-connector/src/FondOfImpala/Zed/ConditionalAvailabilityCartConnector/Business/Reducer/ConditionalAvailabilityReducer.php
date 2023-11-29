<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer;

use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ItemTransfer;

class ConditionalAvailabilityReducer implements ConditionalAvailabilityReducerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function reduce(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer,
        ItemTransfer $itemTransfer
    ): ConditionalAvailabilityTransfer {
        $conditionalAvailabilityPeriodCollectionTransfer = $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection();

        if ($conditionalAvailabilityPeriodCollectionTransfer === null) {
            return $conditionalAvailabilityTransfer;
        }

        $quantity = $itemTransfer->getQuantity();
        $conditionalAvailabilityPeriodTransfers = $conditionalAvailabilityPeriodCollectionTransfer->getConditionalAvailabilityPeriods();

        foreach ($conditionalAvailabilityPeriodTransfers as $conditionalAvailabilityPeriodTransfer) {
            $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

            if ($availableQuantity === 0) {
                continue;
            }

            $conditionalAvailabilityPeriodTransfer->setQuantity(max(0, ($availableQuantity - $quantity)));
        }

        return $conditionalAvailabilityTransfer;
    }
}
