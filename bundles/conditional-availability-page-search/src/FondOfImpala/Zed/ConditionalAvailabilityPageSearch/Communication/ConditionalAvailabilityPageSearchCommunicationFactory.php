<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class ConditionalAvailabilityPageSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventFacadeInterface
     */
    public function getEventFacade(): ConditionalAvailabilityPageSearchToEventFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT);
    }
}
