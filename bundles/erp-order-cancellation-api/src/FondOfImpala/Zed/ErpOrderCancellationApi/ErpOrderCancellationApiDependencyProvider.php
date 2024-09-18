<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi;

use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeBridge;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeBridge;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\QueryContainer\ErpOrderCancellationApiToApiQueryBuilderQueryContainerBridge;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_ERP_ORDER_CANCELLATION = 'FACADE_ERP_ORDER_CANCELLATION';

    /**
     * @var string
     */
    public const FACADE_API = 'FACADE_API';

    /**
     * @var string
     */
    public const QUERY_CONTAINER_API_QUERY_BUILDER = 'QUERY_CONTAINER_API_QUERY_BUILDER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_ERP_ORDER_CANCELLATION = 'PROPEL_QUERY_ERP_ORDER_CANCELLATION';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addErpOrderCancellationFacade($container);

        return $this->addApiFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addErpOrderCancellationFacade(Container $container): Container
    {
        $container[static::FACADE_ERP_ORDER_CANCELLATION] = static function (Container $container) {
            return new ErpOrderCancellationApiToErpOrderCancellationFacadeBridge(
                $container->getLocator()->erpOrderCancellation()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addApiFacade(Container $container): Container
    {
        $container[static::FACADE_API] = static function (Container $container) {
            return new ErpOrderCancellationApiToApiFacadeBridge(
                $container->getLocator()->api()->facade(),
            );
        };

        return $container;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $this->addErpOrderCancellationPropelQuery($container);
        $this->addApiFacade($container);

        return $this->addApiQueryBuilderQueryContainer($container);
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addErpOrderCancellationPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_ERP_ORDER_CANCELLATION] = static function () {
            return FoiErpOrderCancellationQuery::create();
        };

        return $container;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addApiQueryBuilderQueryContainer(Container $container): Container
    {
        $container[static::QUERY_CONTAINER_API_QUERY_BUILDER] = static function (Container $container) {
            return new ErpOrderCancellationApiToApiQueryBuilderQueryContainerBridge(
                $container->getLocator()->apiQueryBuilder()->queryContainer(),
            );
        };

        return $container;
    }
}
