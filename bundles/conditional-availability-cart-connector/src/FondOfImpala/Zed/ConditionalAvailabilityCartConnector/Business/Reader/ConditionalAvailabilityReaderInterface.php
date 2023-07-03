<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader;

use ArrayObject;
use Generated\Shared\Transfer\QuoteTransfer;

interface ConditionalAvailabilityReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \ArrayObject
     */
    public function getGroupedByQuote(QuoteTransfer $quoteTransfer): ArrayObject;
}
