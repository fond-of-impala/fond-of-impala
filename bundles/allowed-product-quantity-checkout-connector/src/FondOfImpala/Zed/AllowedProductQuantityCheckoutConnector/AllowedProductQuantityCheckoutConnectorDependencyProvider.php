<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector;

use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityCheckoutConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_ALLOWED_PRODUCT_QUANTITY_CART_CONNECTOR = 'FACADE_ALLOWED_PRODUCT_QUANTITY_CART_CONNECTOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addAllowedProductQuantityCartConnectorFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAllowedProductQuantityCartConnectorFacade(Container $container): Container
    {
        $container[static::FACADE_ALLOWED_PRODUCT_QUANTITY_CART_CONNECTOR] = static fn (Container $container): AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge => new AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge(
            $container->getLocator()->allowedProductQuantityCartConnector()->facade(),
        );

        return $container;
    }
}
