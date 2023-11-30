<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

interface ConditionalAvailabilityPeriodsFilterInterface
{
    /**
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \ArrayObject|null
     */
    public function filterFromGroupedConditionalAvailabilitiesByItem(
        ArrayObject $groupedConditionalAvailabilities,
        ItemTransfer $itemTransfer
    ): ?ArrayObject;
}
