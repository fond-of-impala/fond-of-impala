<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUserQuote\Business\Model;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Spryker\Zed\Quote\Business\Model\QuoteReaderInterface as SprykerQuoteReaderInterface;

interface CompanyUserQuoteReaderInterface extends SprykerQuoteReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function getFilteredCompanyUserQuoteCollection(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer;
}
