<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface ItemRemoverInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function removeMultiple(QuoteTransfer $quoteTransfer, array $itemTransfers): QuoteResponseTransfer;
}
