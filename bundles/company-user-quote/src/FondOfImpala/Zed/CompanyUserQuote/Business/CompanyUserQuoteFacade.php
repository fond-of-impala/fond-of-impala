<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUserQuote\Business;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Quote\Business\QuoteFacade;

/**
 * @method \FondOfImpala\Zed\CompanyUserQuote\Business\CompanyUserQuoteBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteEntityManagerInterface getEntityManager()
 */
class CompanyUserQuoteFacade extends QuoteFacade implements CompanyUserQuoteFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function getCompanyUserQuoteCollection(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer
    {
        return $this->getFactory()
            ->createCompanyUserQuoteReader()
            ->getFilteredCompanyUserQuoteCollection($quoteCriteriaFilterTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuoteWithCompanyUser(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()
            ->createCompanyUserQuoteExpander()
            ->expand($quoteTransfer);
    }
}
