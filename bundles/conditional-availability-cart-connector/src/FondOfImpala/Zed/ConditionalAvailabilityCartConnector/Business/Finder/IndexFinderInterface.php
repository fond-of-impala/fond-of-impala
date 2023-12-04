<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

interface IndexFinderInterface
{
    /**
     * @param \ArrayObject $conditionalAvailabilityPeriodTransfers
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return int|null
     */
    public function findEarliestFromConditionalAvailabilityPeriods(
        ArrayObject $conditionalAvailabilityPeriodTransfers,
        ItemTransfer $itemTransfer
    ): ?int;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer> $conditionalAvailabilityPeriodTransfers
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return int|null
     */
    public function findConcreteFromConditionalAvailabilityPeriods(
        ArrayObject $conditionalAvailabilityPeriodTransfers,
        ItemTransfer $itemTransfer
    ): ?int;
}
