<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade;

use Generated\Shared\Transfer\QuoteTransfer;

interface ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string>
     */
    public function getUnavailableSkusByQuote(
        QuoteTransfer $quoteTransfer
    ): array;
}
