<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui;

use FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityGuiDependencyProvider extends AbstractBundleDependencyProvider
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
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        return $this->addAllowedProductQuantityFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAllowedProductQuantityFacade(Container $container): Container
    {
        $container[static::FACADE_ALLOWED_PRODUCT_QUANTITY] = static fn (Container $container): AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridge => new AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridge(
            $container->getLocator()->allowedProductQuantity()->facade(),
        );

        return $container;
    }
}
