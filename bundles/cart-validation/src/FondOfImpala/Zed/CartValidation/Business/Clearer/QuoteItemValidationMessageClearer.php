<?php

namespace FondOfImpala\Zed\CartValidation\Business\Clearer;

use ArrayObject;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteItemValidationMessageClearer implements QuoteItemValidationMessageClearerInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function clear(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $itemTransfer->setValidationMessages(new ArrayObject());
        }

        return $quoteTransfer;
    }
}
