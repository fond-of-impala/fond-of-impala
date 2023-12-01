<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

class ConditionalAvailabilityPeriodsReducer implements ConditionalAvailabilityPeriodsReducerInterface
{
    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer> $conditionalAvailabilityPeriodTransfers
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param int $effectedIndex
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>
     */
    public function reduceByItemAndEffectedIndex(
        ArrayObject $conditionalAvailabilityPeriodTransfers,
        ItemTransfer $itemTransfer,
        int $effectedIndex
    ): ArrayObject {
        $quantity = $itemTransfer->getQuantity();
        $effectedPeriodQuantity = $conditionalAvailabilityPeriodTransfers->offsetGet($effectedIndex)
            ->getQuantity() - $quantity;

        foreach ($conditionalAvailabilityPeriodTransfers as $index => $conditionalAvailabilityPeriodTransfer) {
            if ($effectedIndex === $index) {
                $conditionalAvailabilityPeriodTransfer->setQuantity($effectedPeriodQuantity);

                continue;
            }

            $periodQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

            if ($effectedIndex < $index) {
                $conditionalAvailabilityPeriodTransfer->setQuantity($periodQuantity - $quantity);

                continue;
            }

            if ($periodQuantity <= $effectedPeriodQuantity) {
                continue;
            }

            $conditionalAvailabilityPeriodTransfer->setQuantity($periodQuantity - $quantity);
        }

        return $conditionalAvailabilityPeriodTransfers;
    }
}
