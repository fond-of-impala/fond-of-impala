<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

interface ConditionalAvailabilityPeriodsReducerInterface
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
    ): ArrayObject;
}
