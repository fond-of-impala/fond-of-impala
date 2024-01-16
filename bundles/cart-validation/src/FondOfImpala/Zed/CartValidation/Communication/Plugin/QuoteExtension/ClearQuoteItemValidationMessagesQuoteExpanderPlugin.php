<?php

namespace FondOfImpala\Zed\CartValidation\Communication\Plugin\QuoteExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteExpanderPluginInterface;

/**
 * @method \FondOfImpala\Zed\CartValidation\Business\CartValidationFacadeInterface getFacade()
 */
class ClearQuoteItemValidationMessagesQuoteExpanderPlugin extends AbstractPlugin implements QuoteExpanderPluginInterface
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
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFacade()->clearQuoteItemValidationMessages($quoteTransfer);
    }
}
