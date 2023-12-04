<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader;

use Generated\Shared\Transfer\QuoteTransfer;

interface UnavailableSkuReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string>
     */
    public function getByQuote(QuoteTransfer $quoteTransfer): array;
}
