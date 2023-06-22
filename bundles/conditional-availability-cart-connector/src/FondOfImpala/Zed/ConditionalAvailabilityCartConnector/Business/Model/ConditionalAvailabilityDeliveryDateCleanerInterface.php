<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use Generated\Shared\Transfer\QuoteTransfer;

interface ConditionalAvailabilityDeliveryDateCleanerInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function cleanDeliveryDate(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
