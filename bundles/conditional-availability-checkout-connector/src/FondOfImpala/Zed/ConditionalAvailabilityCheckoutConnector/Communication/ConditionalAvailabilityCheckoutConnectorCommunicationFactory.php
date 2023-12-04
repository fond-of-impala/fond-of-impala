<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication;

use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\ConditionalAvailabilityCheckoutConnectorDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityCheckoutConnectorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface
     */
    public function getConditionalAvailabilityCartConnectorFacade(): ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCheckoutConnectorDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY_CART_CONNECTOR,
        );
    }
}
