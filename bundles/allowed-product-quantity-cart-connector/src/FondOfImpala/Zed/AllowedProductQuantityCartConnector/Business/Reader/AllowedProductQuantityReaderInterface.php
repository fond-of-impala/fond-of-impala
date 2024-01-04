<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader;

use ArrayObject;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ItemTransfer;

interface AllowedProductQuantityReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityTransfer|null
     */
    public function getByItem(ItemTransfer $itemTransfer): ?AllowedProductQuantityTransfer;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\AllowedProductQuantityTransfer>
     */
    public function getGroupedByItems(ArrayObject $itemTransfers): array;
}
