<?php

namespace FondOfImpala\Zed\PriceListApi;

use FondOfImpala\Zed\PriceListApi\Communication\Plugin\PriceListApi\ProductIdsPriceProductsHydrationPlugin;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeBridge;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeBridge;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeBridge;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeBridge;
use FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerBridge;
use Orm\Zed\PriceList\Persistence\FoiPriceListQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class PriceListApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PRICE_LIST = 'FACADE_PRICE_LIST';

    /**
     * @var string
     */
    public const FACADE_PRICE_PRODUCT_PRICE_LIST = 'FACADE_PRICE_PRODUCT_PRICE_LIST';

    /**
     * @var string
     */
    public const FACADE_PRODUCT = 'FACADE_PRODUCT';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCTS_HYDRATION = 'PLUGINS_PRICE_PRODUCTS_HYDRATION';

    /**
     * @var string
     */
    public const PROPEL_CONNECTION = 'PROPEL_CONNECTION';

    /**
     * @var string
     */
    public const FACADE_API = 'FACADE_API';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PRICE_LIST = 'PROPEL_QUERY_PRICE_LIST';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PRODUCT_ABSTRACT = 'PROPEL_QUERY_ABSTRACT_PRODUCT';

    /**
     * @var string
     */
    public const QUERY_CONTAINER_API_QUERY_BUILDER = 'QUERY_CONTAINER_API_QUERY_BUILDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addPriceListFacade($container);
        $container = $this->addPriceProductPriceListFacade($container);
        $container = $this->addProductFacade($container);
        $container = $this->addPropelCommunication($container);
        $container = $this->addPriceProductHydrationPlugins($container);
        $container = $this->provideApiFacade($container);

        return $this->provideApiQueryBuilderQueryContainer($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container = $this->addPriceListPropelQuery($container);

        return $this->addProductAbstractPropelQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceListFacade(Container $container): Container
    {
        $container[static::FACADE_PRICE_LIST] = static fn (Container $container): PriceListApiToPriceListFacadeBridge => new PriceListApiToPriceListFacadeBridge($container->getLocator()->priceList()->facade());

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductPriceListFacade(Container $container): Container
    {
        $container[static::FACADE_PRICE_PRODUCT_PRICE_LIST] = static fn (Container $container): PriceListApiToPriceProductPriceListFacadeBridge => new PriceListApiToPriceProductPriceListFacadeBridge($container->getLocator()->priceProductPriceList()->facade());

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT] = static fn (Container $container): PriceListApiToProductFacadeBridge => new PriceListApiToProductFacadeBridge($container->getLocator()->product()->facade());

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPropelCommunication(Container $container): Container
    {
        $container[static::PROPEL_CONNECTION] = static fn (): ConnectionInterface => Propel::getConnection();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductHydrationPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PRICE_PRODUCTS_HYDRATION] = static fn (): array => $self->getPriceProductsHydrationPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\PriceListApi\Dependency\Plugin\PriceProductsHydrationPluginInterface>
     */
    protected function getPriceProductsHydrationPlugins(): array
    {
        return [
            new ProductIdsPriceProductsHydrationPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideApiFacade(Container $container): Container
    {
        $container[static::FACADE_API] = static fn (Container $container): PriceListApiToApiFacadeBridge => new PriceListApiToApiFacadeBridge($container->getLocator()->api()->facade());

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceListPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PRICE_LIST] = static fn (): FoiPriceListQuery => FoiPriceListQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PRODUCT_ABSTRACT] = static fn (): SpyProductAbstractQuery => SpyProductAbstractQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideApiQueryBuilderQueryContainer(Container $container): Container
    {
        $container[static::QUERY_CONTAINER_API_QUERY_BUILDER] = static fn (Container $container): PriceListApiToApiQueryBuilderQueryContainerBridge => new PriceListApiToApiQueryBuilderQueryContainerBridge(
            $container->getLocator()->apiQueryBuilder()->queryContainer(),
        );

        return $container;
    }
}
