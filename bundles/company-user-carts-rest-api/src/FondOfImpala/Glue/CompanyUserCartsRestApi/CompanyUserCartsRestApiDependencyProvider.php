<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class CompanyUserCartsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_REST_CART_ITEM_EXPANDER = 'PLUGINS_REST_CART_ITEM_EXPANDER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        return $this->addRestCartItemExpanderPlugins($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addRestCartItemExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_REST_CART_ITEM_EXPANDER] = static function () use ($self) {
            return $self->getRestCartItemExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface>
     */
    protected function getRestCartItemExpanderPlugins(): array
    {
        return [];
    }
}
