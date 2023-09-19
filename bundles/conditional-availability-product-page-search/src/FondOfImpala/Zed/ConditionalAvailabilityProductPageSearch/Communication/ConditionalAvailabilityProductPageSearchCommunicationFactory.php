<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReader;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class ConditionalAvailabilityProductPageSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface
     */
    public function createProductAbstractReader(): ProductAbstractReaderInterface
    {
        return new ProductAbstractReader($this->getProductFacade());
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface
     */
    public function getEventBehaviorFacade(): ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
     */
    public function getProductPageSearchFacade(): ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT_PAGE_SEARCH);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected function getProductFacade(): ConditionalAvailabilityProductPageSearchToProductFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    public function getConditionalAvailabilityFacade(): ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY);
    }
}
