<?php

namespace FondOfImpala\Client\EnhancedCatalog;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class EnhancedCatalogDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_PRODUCT_EXPANDER = 'PLUGINS_PRODUCT_EXPANDER';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        return $this->addProductExpanderPlugins($container);
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addProductExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRODUCT_EXPANDER] = fn (): array => $this->getProductExpanderPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface>
     */
    protected function getProductExpanderPlugins(): array
    {
        return [];
    }
}
