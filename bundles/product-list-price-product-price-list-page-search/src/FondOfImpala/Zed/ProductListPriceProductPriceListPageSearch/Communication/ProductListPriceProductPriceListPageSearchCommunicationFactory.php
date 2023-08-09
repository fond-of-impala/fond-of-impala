<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication;

use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeInterface;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductFacadeInterface;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacadeInterface getFacade()
 */
class ProductListPriceProductPriceListPageSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeInterface
     */
    public function getPriceProductPriceListPageSearchFacade(): ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeInterface
     */
    public function getEventBehaviorFacade(): ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductFacadeInterface
     */
    public function getProductFacade(): ProductListPriceProductPriceListPageSearchToProductFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRODUCT,
        );
    }
}
