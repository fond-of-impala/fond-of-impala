<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class OrderBudgetsBulkRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_ORDER_BUDGET_MAPPER = 'PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_ORDER_BUDGET_MAPPER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        return $this->addRestOrderBudgetsBulkRequestOrderBudgetMapperPlugins($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addRestOrderBudgetsBulkRequestOrderBudgetMapperPlugins(Container $container): Container
    {
        $container[static::PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_ORDER_BUDGET_MAPPER] = fn (): array => $this->getRestOrderBudgetsBulkRequestOrderBudgetMapperPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface>
     */
    protected function getRestOrderBudgetsBulkRequestOrderBudgetMapperPlugins(): array
    {
        return [];
    }
}
