<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;

class ItemFinder implements ItemFinderInterface
{
    /**
     * @param array<string, \Generated\Shared\Transfer\ItemTransfer> $groupedItemTransfers
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer|null
     */
    public function findInGroupedItemsByRestCartItem(
        array $groupedItemTransfers,
        RestCartItemTransfer $restCartItemTransfer
    ): ?ItemTransfer {
        if (isset($groupedItemTransfers[$restCartItemTransfer->getGroupKey()])) {
            return $groupedItemTransfers[$restCartItemTransfer->getGroupKey()];
        }

        if (isset($groupedItemTransfers[$restCartItemTransfer->getSku()])) {
            return $groupedItemTransfers[$restCartItemTransfer->getSku()];
        }

        return null;
    }
}
