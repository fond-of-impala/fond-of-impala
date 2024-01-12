<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication;

use FondOfImpala\Zed\AllowedProductQuantitySearch\AllowedProductQuantitySearchDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToProductPageSearchFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\AllowedProductQuantitySearchConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\Business\AllowedProductQuantitySearchFacadeInterface getFacade()
 */
class AllowedProductQuantitySearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface
     */
    public function getAllowedProductQuantityFacade(): AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface
    {
        return $this->getProvidedDependency(AllowedProductQuantitySearchDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY);
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToEventBehaviorFacadeInterface
     */
    public function getEventBehaviorFacade(): AllowedProductQuantitySearchToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(AllowedProductQuantitySearchDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToProductPageSearchFacadeInterface
     */
    public function getProductPageSearchFacade(): AllowedProductQuantitySearchToProductPageSearchFacadeInterface
    {
        return $this->getProvidedDependency(AllowedProductQuantitySearchDependencyProvider::FACADE_PRODUCT_PAGE_SEARCH);
    }
}
