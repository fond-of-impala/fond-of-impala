<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector;

use Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class SplittableCheckoutOrderTypeConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_TABLE_MAP_ORDER_TYPES = 'PROPEL_TABLE_MAP_ORDER_TYPES';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addOrderTypesTableMap($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderTypesTableMap(Container $container): Container
    {
        $container[static::PROPEL_TABLE_MAP_ORDER_TYPES] = static fn (): array => SpySalesOrderTableMap::getValueSet(SpySalesOrderTableMap::COL_ORDER_TYPE);

        return $container;
    }
}
