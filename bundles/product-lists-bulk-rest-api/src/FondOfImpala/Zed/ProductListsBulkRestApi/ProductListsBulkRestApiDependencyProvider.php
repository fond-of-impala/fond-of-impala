<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi;

use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeBridge;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use Orm\Zed\ProductList\Persistence\Base\SpyProductListQuery as BaseSpyProductListQuery;
use Orm\Zed\ProductList\Persistence\SpyProductListQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class ProductListsBulkRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT = 'FACADE_EVENT';

    /**
     * @var string
     */
    public const PLUGINS_PRODUCT_LIST_IDS_REDUCER = 'PLUGINS_PRODUCT_LIST_IDS_REDUCER';

    /**
     * @var string
     */
    public const PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_EXPANDER = 'PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_PRE_CHECK = 'PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_PRE_CHECK';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PRODUCT_LIST = 'PROPEL_QUERY_PRODUCT_LIST';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addEventFacade($container);
        $container = $this->addProductListIdsReducerPlugins($container);
        $container = $this->addRestProductListsBulkRequestExpanderPlugins($container);

        return $this->addRestProductListsBulkRequestAssignmentPreCheckPlugins($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT] = static fn (
            Container $container
        ): ProductListsBulkRestApiToEventFacadeInterface => new ProductListsBulkRestApiToEventFacadeBridge(
            $container->getLocator()->event()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductListIdsReducerPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRODUCT_LIST_IDS_REDUCER] = fn (): array => $this->getProductListIdsReducerPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\ProductListIdsReducerPluginInterface>
     */
    protected function getProductListIdsReducerPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addRestProductListsBulkRequestExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_EXPANDER] = fn (): array => $this->getRestProductListsBulkRequestExpanderPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface>
     */
    protected function getRestProductListsBulkRequestExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addRestProductListsBulkRequestAssignmentPreCheckPlugins(Container $container): Container
    {
        $container[static::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_PRE_CHECK] = fn (): array => $this->getRestProductListsBulkRequestAssignmentPreCheckPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentPreCheckPluginInterface>
     */
    public function getRestProductListsBulkRequestAssignmentPreCheckPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addProductListQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductListQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PRODUCT_LIST] = static fn (): BaseSpyProductListQuery => SpyProductListQuery::create();

        return $container;
    }
}
