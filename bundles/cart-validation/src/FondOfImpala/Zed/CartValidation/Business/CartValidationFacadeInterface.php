<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CartValidation\Business;

use Generated\Shared\Transfer\QuoteTransfer;

interface CartValidationFacadeInterface
{
    /**
     * Specification:
     * - Clears validation messages on quote level
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function clearQuoteValidationMessages(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * Specification:
     * - Clears validation messages on quote item level
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function clearQuoteItemValidationMessages(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
