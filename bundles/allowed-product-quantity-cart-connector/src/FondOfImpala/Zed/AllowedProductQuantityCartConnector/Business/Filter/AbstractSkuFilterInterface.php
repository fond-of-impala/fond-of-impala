<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

interface AbstractSkuFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string|null
     */
    public function filterFromItem(ItemTransfer $itemTransfer): ?string;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<string>
     */
    public function filterFromItems(ArrayObject $itemTransfers): array;
}
