<?php

namespace FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business\WebUiSettingsQuoteConnectorBusinessFactory getFactory()
 */
class WebUiSettingsQuoteConnectorFacade extends AbstractFacade implements WebUiSettingsQuoteConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()->createQuoteExpander()->expand($quoteTransfer);
    }
}
