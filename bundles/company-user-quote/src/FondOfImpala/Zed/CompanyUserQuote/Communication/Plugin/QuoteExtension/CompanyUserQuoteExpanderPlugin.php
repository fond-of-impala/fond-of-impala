<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Communication\Plugin\QuoteExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteExpanderPluginInterface;

/**
 * @method \FondOfImpala\Zed\CompanyUserQuote\CompanyUserQuoteConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyUserQuote\Business\CompanyUserQuoteFacadeInterface getFacade()
 */
class CompanyUserQuoteExpanderPlugin extends AbstractPlugin implements QuoteExpanderPluginInterface
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
        return $this->getFacade()->expandQuoteWithCompanyUser($quoteTransfer);
    }
}
