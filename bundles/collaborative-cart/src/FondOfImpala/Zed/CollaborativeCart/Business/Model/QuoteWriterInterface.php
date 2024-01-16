<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Generated\Shared\Transfer\QuoteTransfer;

interface QuoteWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    public function update(QuoteTransfer $quoteTransfer): ?QuoteTransfer;
}
