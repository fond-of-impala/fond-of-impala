<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper;

use ArrayObject;
use Generated\Shared\Transfer\QuoteTransfer;

class ItemsGrouper implements ItemsGrouperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \ArrayObject<string, \ArrayObject<int, \Generated\Shared\Transfer\ItemTransfer>>
     */
    public function group(QuoteTransfer $quoteTransfer): ArrayObject
    {
        /** @var \ArrayObject<string, \ArrayObject<int, \Generated\Shared\Transfer\ItemTransfer>> $groupedItemTransfers */
        $groupedItemTransfers = new ArrayObject();

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $sku = $itemTransfer->getSku();

            if (!$groupedItemTransfers->offsetExists($sku)) {
                $groupedItemTransfers->offsetSet($sku, new ArrayObject());
            }

            $groupedItemTransfers->offsetGet($sku)->append($itemTransfer);
        }

        return $groupedItemTransfers;
    }
}
