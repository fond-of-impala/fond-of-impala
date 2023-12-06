<?php

namespace FondOfImpala\Zed\ProductProductListConnector;

use Orm\Zed\ProductList\Persistence\SpyProductListProductConcreteQuery;
use Orm\Zed\ProductList\Persistence\SpyProductListQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductProductListConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_PRODUCT_LIST = 'QUERY_PRODUCT_LIST';

    /**
     * @var string
     */
    public const QUERY_PRODUCT_LIST_PRODUCT_CONCRETE = 'QUERY_PRODUCT_LIST_PRODUCT_CONCRETE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addProductListQuery($container);

        return $this->addProductListProductConcreteQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductListQuery(Container $container): Container
    {
        $container[static::QUERY_PRODUCT_LIST] = static fn (Container $container): SpyProductListQuery => SpyProductListQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductListProductConcreteQuery(Container $container): Container
    {
        $container[static::QUERY_PRODUCT_LIST_PRODUCT_CONCRETE] = static fn (Container $container): SpyProductListProductConcreteQuery => SpyProductListProductConcreteQuery::create();

        return $container;
    }
}
