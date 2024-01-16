<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface CompanyUserReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getActiveByClaimCartRequestAndQuote(
        ClaimCartRequestTransfer $claimCartRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): ?CompanyUserTransfer;
}
