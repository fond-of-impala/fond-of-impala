<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication;

use FondOfImpala\Zed\ConditionalAvailabilitySearch\ConditionalAvailabilitySearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductPageSearchFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class ConditionalAvailabilitySearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToEventBehaviorFacadeInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getEventBehaviorFacade(): ConditionalAvailabilitySearchToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilitySearchDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductPageSearchFacadeInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getProductPageSearchFacade(): ConditionalAvailabilitySearchToProductPageSearchFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilitySearchDependencyProvider::FACADE_PRODUCT_PAGE_SEARCH);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getConditionalAvailabilityFacade(): ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilitySearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY);
    }

}
