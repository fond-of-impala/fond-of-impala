<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper;

use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface ConditionalAvailabilityCriteriaFilterMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer|null
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): ?ConditionalAvailabilityCriteriaFilterTransfer;
}
