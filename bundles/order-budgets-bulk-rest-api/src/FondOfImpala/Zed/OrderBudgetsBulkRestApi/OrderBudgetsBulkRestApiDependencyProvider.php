<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeBridge;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeBridge;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface;
use Orm\Zed\OrderBudget\Persistence\Base\FooOrderBudgetQuery as BaseFooOrderBudgetQuery;
use Orm\Zed\OrderBudget\Persistence\FooOrderBudgetQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class OrderBudgetsBulkRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT = 'FACADE_EVENT';

    /**
     * @var string
     */
    public const PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_EXPANDER = 'PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_EXPANDER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_ORDER_BUDGET = 'PROPEL_QUERY_ORDER_BUDGET';

    /**
     * @var string
     */
    public const FACADE_ORDER_BUDGET = 'FACADE_ORDER_BUDGET';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addEventFacade($container);
        $container = $this->addOrderBudgetFacade($container);

        return $this->addRestOrderBudgetsBulkRequestExpanderPlugins($container);
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
        ): OrderBudgetsBulkRestApiToEventFacadeInterface => new OrderBudgetsBulkRestApiToEventFacadeBridge(
            $container->getLocator()->event()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addRestOrderBudgetsBulkRequestExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_EXPANDER] = fn (): array => $this->getRestOrderBudgetsBulkRequestExpanderPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestExpanderPluginInterface>
     */
    protected function getRestOrderBudgetsBulkRequestExpanderPlugins(): array
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

        return $this->addOrderBudgetQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderBudgetQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_ORDER_BUDGET] = static fn (): BaseFooOrderBudgetQuery => FooOrderBudgetQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderBudgetFacade(Container $container): Container
    {
        $container[static::FACADE_ORDER_BUDGET] = static fn (
            Container $container
        ): OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface => new OrderBudgetsBulkRestApiToOrderBudgetFacadeBridge(
            $container->getLocator()->orderBudget()->facade(),
        );

        return $container;
    }
}
