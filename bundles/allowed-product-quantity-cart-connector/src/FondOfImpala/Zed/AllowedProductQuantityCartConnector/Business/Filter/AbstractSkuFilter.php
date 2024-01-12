<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

class AbstractSkuFilter implements AbstractSkuFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string|null
     */
    public function filterFromItem(ItemTransfer $itemTransfer): ?string
    {
        return $itemTransfer->getAbstractSku();
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<string>
     */
    public function filterFromItems(ArrayObject $itemTransfers): array
    {
        $abstractSkus = [];

        foreach ($itemTransfers as $itemTransfer) {
            $abstractSku = $this->filterFromItem($itemTransfer);
            if ($abstractSku === null) {
                continue;
            }
            if (in_array($abstractSku, $abstractSkus, true)) {
                continue;
            }

            $abstractSkus[] = $abstractSku;
        }

        return $abstractSkus;
    }
}
