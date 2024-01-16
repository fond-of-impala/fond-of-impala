<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\CompanyUserQuote;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;

interface CompanyUserQuoteClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function getCompanyUserQuoteCollectionByCriteria(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer;
}
