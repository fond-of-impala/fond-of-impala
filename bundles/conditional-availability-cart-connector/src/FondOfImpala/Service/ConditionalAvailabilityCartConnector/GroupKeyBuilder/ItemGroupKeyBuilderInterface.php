<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Generated\Shared\Transfer\ItemTransfer;

interface ItemGroupKeyBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    public function build(ItemTransfer $itemTransfer): string;
}
