<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper;

use Generated\Shared\Transfer\QuoteTransfer;

class ItemsGrouper implements ItemsGrouperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string, \Generated\Shared\Transfer\ItemTransfer>
     */
    public function groupByQuote(QuoteTransfer $quoteTransfer): array
    {
        $groupedItemTransfers = [];

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $searchKey = $itemTransfer->getGroupKey() ?? $itemTransfer->getSku();
            $groupedItemTransfers[$searchKey] = $itemTransfer;
        }

        return $groupedItemTransfers;
    }
}
