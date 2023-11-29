<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer;

use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ItemTransfer;

interface ConditionalAvailabilityReducerInterface
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
    ): ConditionalAvailabilityTransfer;
}
