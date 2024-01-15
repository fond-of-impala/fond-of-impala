<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Business\Model;

use Generated\Shared\Transfer\QuoteTransfer;

interface CompanyUserQuoteExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
