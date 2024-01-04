<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade;

use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\ItemTransfer;

class AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge implements AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface
{
    protected AllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacade
     */
    public function __construct(
        AllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacade
    ) {
        $this->allowedProductQuantityCartConnectorFacade = $allowedProductQuantityCartConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return array<\Generated\Shared\Transfer\MessageTransfer>
     */
    public function validateQuoteItem(ItemTransfer $itemTransfer): array
    {
        return $this->allowedProductQuantityCartConnectorFacade->validateQuoteItem($itemTransfer);
    }
}
