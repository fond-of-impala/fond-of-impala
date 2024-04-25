<?php

namespace FondOfImpala\Zed\WebUiSettingsQuoteConnector\Communication\Plugin\QuoteExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteExpanderPluginInterface;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business\WebUiSettingsQuoteConnectorFacadeInterface getFacade()
 */
class CartViewQuoteExpanderPlugin extends AbstractPlugin implements QuoteExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFacade()->expandQuote($quoteTransfer);
    }
}
