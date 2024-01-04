<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector;

use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityCartConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_ALLOWED_PRODUCT_QUANTITY = 'FACADE_ALLOWED_PRODUCT_QUANTITY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addAllowedProductQuantityFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAllowedProductQuantityFacade(Container $container): Container
    {
        $container[static::FACADE_ALLOWED_PRODUCT_QUANTITY] = static fn (Container $container): AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridge => new AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridge(
            $container->getLocator()->allowedProductQuantity()->facade(),
        );

        return $container;
    }
}
