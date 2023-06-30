<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter;

use Generated\Shared\Transfer\QuoteTransfer;

interface SkusFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string>
     */
    public function filterFromQuote(QuoteTransfer $quoteTransfer): array;
}
