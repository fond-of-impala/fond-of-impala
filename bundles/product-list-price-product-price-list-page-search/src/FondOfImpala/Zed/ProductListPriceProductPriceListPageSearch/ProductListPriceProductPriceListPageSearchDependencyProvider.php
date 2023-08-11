<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch;

use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeBridge;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductFacadeBridge;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductListPriceProductPriceListPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const FACADE_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH = 'FACADE_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH';

    /**
     * @var string
     */
    public const FACADE_PRODUCT = 'FACADE_PRODUCT';

    /**
     * @var string
     */
    public const FACADE_PRODUCT_LIST = 'FACADE_PRODUCT_LIST';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addProductListFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addEventBehaviorFacade($container);
        $container = $this->addPriceProductPriceListPageSearchFacade($container);
        $container = $this->addProductFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductListFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT_LIST] = static fn (Container $container): ProductListPriceProductPriceListPageSearchToProductListFacadeBridge => new ProductListPriceProductPriceListPageSearchToProductListFacadeBridge(
            $container->getLocator()->productList()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviorFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT_BEHAVIOR] = static fn (Container $container): ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge => new ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge(
            $container->getLocator()->eventBehavior()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductPriceListPageSearchFacade(Container $container): Container
    {
        $container[static::FACADE_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH] = static fn (Container $container): ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeBridge => new ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeBridge(
            $container->getLocator()->priceProductPriceListPageSearch()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT] = static fn (Container $container): ProductListPriceProductPriceListPageSearchToProductFacadeBridge => new ProductListPriceProductPriceListPageSearchToProductFacadeBridge(
            $container->getLocator()->product()->facade(),
        );

        return $container;
    }
}
