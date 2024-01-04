<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface AllowedProductQuantityCartConnectorFacadeInterface
{
    /**
     * Specification:
     * - Validate quote quantities.
     * - Check if quantity is greater then specific min.
     * - Check if quantity is lower then specific max.
     * - Check if quantity is in specific interval.
     * - Add messages to quote items.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function validateQuote(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * Specification:
     * - Validate quote item quantity.
     * - Check if quantity is greater then specific min.
     * - Check if quantity is lower then specific max.
     * - Check if quantity is in specific interval.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return array<\Generated\Shared\Transfer\MessageTransfer>
     */
    public function validateQuoteItem(ItemTransfer $itemTransfer): array;
}
