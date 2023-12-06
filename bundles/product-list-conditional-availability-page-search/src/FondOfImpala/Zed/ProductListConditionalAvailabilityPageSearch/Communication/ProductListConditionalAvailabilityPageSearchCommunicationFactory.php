<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication;

use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacadeInterface getFacade()
 */
class ProductListConditionalAvailabilityPageSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface
     */
    public function getConditionalAvailabilityFacade(): ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
     */
    public function getEventBehaviorFacade(): ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR,
        );
    }
}
