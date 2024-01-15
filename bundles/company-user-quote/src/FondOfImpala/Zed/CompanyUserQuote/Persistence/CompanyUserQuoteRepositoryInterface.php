<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUserQuote\Persistence;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Spryker\Zed\Quote\Persistence\QuoteRepositoryInterface;

interface CompanyUserQuoteRepositoryInterface extends QuoteRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function filterCompanyUserQuoteCollection(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer;
}
