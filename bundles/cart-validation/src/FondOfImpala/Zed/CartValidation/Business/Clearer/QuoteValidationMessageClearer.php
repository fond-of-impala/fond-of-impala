<?php

namespace FondOfImpala\Zed\CartValidation\Business\Clearer;

use ArrayObject;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteValidationMessageClearer implements QuoteValidationMessageClearerInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function clear(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $quoteTransfer->setValidationMessages(new ArrayObject());
    }
}
