<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use ArrayObject;
use DateTimeInterface;
use Generated\Shared\Transfer\ItemTransfer;

interface EarliestDeliveryDateGeneratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer> $conditionalAvailabilityPeriodTransfers
     *
     * @return \DateTimeInterface|null
     */
    public function generateByItemAndConditionalAvailabilityPeriods(
        ItemTransfer $itemTransfer,
        ArrayObject $conditionalAvailabilityPeriodTransfers
    ): ?DateTimeInterface;
}
