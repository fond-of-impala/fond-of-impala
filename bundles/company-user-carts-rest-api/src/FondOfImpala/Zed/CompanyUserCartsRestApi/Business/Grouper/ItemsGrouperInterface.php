<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper;

use Generated\Shared\Transfer\QuoteTransfer;

interface ItemsGrouperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string, \Generated\Shared\Transfer\ItemTransfer>
     */
    public function groupByQuote(QuoteTransfer $quoteTransfer): array;
}
