<?php

namespace FondOfImpala\Zed\CollaborativeCart\Communication\Plugin\QuoteExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteExpanderPluginInterface;

/**
 * @method \FondOfImpala\Zed\CollaborativeCart\CollaborativeCartConfig getConfig()
 * @method \FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartFacadeInterface getFacade()
 */
class CollaborativeCartQuoteExpanderPlugin extends AbstractPlugin implements QuoteExpanderPluginInterface
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
