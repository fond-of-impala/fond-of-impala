<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface ItemAdderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function addMultiple(QuoteTransfer $quoteTransfer, array $itemTransfers): QuoteResponseTransfer;
}
