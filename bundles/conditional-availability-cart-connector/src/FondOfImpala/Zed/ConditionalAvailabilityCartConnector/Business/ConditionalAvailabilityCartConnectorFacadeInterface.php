<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface ConditionalAvailabilityCartConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandChangedCartItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function cleanDeliveryDateOnEmptyCart(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function ensureEarliestDate(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
