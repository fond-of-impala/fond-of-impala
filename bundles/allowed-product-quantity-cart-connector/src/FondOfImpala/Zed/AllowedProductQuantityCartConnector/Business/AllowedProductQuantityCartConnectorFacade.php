<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorBusinessFactory getFactory()
 */
class AllowedProductQuantityCartConnectorFacade extends AbstractFacade implements AllowedProductQuantityCartConnectorFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function validateQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()->createQuoteValidator()->validateAndAppendResult($quoteTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return array<\Generated\Shared\Transfer\MessageTransfer>
     */
    public function validateQuoteItem(ItemTransfer $itemTransfer): array
    {
        return $this->getFactory()->createItemValidator()->validate($itemTransfer)->getArrayCopy();
    }
}
