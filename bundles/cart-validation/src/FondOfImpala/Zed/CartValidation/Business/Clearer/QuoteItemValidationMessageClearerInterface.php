<?php

namespace FondOfImpala\Zed\CartValidation\Business\Clearer;

use Generated\Shared\Transfer\QuoteTransfer;

interface QuoteItemValidationMessageClearerInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function clear(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
