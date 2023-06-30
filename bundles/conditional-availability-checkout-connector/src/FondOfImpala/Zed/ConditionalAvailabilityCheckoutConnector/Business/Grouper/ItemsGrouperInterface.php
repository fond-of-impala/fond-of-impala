<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper;

use ArrayObject;
use Generated\Shared\Transfer\QuoteTransfer;

interface ItemsGrouperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \ArrayObject<string, \ArrayObject<int, \Generated\Shared\Transfer\ItemTransfer>>
     */
    public function group(QuoteTransfer $quoteTransfer): ArrayObject;
}
