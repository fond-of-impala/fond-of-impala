<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

interface ItemExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function expand(
        ItemTransfer $itemTransfer,
        ArrayObject $groupedConditionalAvailabilities
    ): ItemTransfer;
}
