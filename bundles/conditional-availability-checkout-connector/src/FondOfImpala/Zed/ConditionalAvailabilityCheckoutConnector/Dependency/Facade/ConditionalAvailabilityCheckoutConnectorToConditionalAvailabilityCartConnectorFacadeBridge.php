<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeBridge implements ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface
{
    protected ConditionalAvailabilityCartConnectorFacadeInterface $conditionalAvailabilityCartConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface $conditionalAvailabilityCartConnectorFacade
     */
    public function __construct(ConditionalAvailabilityCartConnectorFacadeInterface $conditionalAvailabilityCartConnectorFacade)
    {
        $this->conditionalAvailabilityCartConnectorFacade = $conditionalAvailabilityCartConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string>
     */
    public function getUnavailableSkusByQuote(
        QuoteTransfer $quoteTransfer
    ): array {
        return $this->conditionalAvailabilityCartConnectorFacade->getUnavailableSkusByQuote($quoteTransfer);
    }
}
