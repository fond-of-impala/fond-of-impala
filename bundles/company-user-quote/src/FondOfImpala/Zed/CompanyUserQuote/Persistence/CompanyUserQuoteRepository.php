<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUserQuote\Persistence;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Orm\Zed\Quote\Persistence\SpyQuoteQuery;
use Spryker\Zed\Quote\Persistence\QuoteRepository;

/**
 * @method \FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuotePersistenceFactory getFactory()
 */
class CompanyUserQuoteRepository extends QuoteRepository implements CompanyUserQuoteRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function filterCompanyUserQuoteCollection(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer
    {
        $quoteQuery = $this->getFactory()
            ->createQuoteQuery()
            ->joinWithSpyStore();

        $quoteQuery = $this->applyCompanyUserQuoteCriteriaFilters($quoteQuery, $quoteCriteriaFilterTransfer);
        $quoteEntityCollectionTransfer = $this->buildQueryFromCriteria($quoteQuery, $quoteCriteriaFilterTransfer->getFilter())->find();

        $quoteCollectionTransfer = new QuoteCollectionTransfer();
        foreach ($quoteEntityCollectionTransfer as $quoteEntityTransfer) {
            $quoteCollectionTransfer->addQuote($this->mapQuoteTransfer($quoteEntityTransfer));
        }

        return $quoteCollectionTransfer;
    }

    /**
     * @param \Orm\Zed\Quote\Persistence\SpyQuoteQuery $quoteQuery
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Orm\Zed\Quote\Persistence\SpyQuoteQuery
     */
    protected function applyCompanyUserQuoteCriteriaFilters(SpyQuoteQuery $quoteQuery, QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): SpyQuoteQuery
    {
        $quoteQuery = $this->applyQuoteCriteriaFilters($quoteQuery, $quoteCriteriaFilterTransfer);

        if ($quoteCriteriaFilterTransfer->getCompanyUserReference() !== null) {
            $quoteQuery->filterByCompanyUserReference($quoteCriteriaFilterTransfer->getCompanyUserReference());
        }

        if ($quoteCriteriaFilterTransfer->getUuid() !== null) {
            $quoteQuery->filterByUuid($quoteCriteriaFilterTransfer->getUuid());
        }

        return $quoteQuery;
    }
}
