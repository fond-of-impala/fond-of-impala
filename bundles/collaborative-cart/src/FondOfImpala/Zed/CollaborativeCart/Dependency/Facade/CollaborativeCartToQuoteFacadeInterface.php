<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface CollaborativeCartToQuoteFacadeInterface
{
    /**
     * @param int $idQuote
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function findQuoteById(int $idQuote): QuoteResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function updateQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer;
}
