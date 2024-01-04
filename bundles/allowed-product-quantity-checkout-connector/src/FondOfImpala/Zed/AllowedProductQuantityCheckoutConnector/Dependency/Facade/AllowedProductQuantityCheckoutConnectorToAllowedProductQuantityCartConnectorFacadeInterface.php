<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade;

use Generated\Shared\Transfer\ItemTransfer;

interface AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return array<\Generated\Shared\Transfer\MessageTransfer>
     */
    public function validateQuoteItem(ItemTransfer $itemTransfer): array;
}
