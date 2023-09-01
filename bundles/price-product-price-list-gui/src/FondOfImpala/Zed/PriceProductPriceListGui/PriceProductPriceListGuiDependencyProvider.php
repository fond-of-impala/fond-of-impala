<?php

namespace FondOfImpala\Zed\PriceProductPriceListGui;

use FondOfImpala\Zed\PriceProductPriceListGui\Dependency\Facade\PriceProductPriceListGuiToPriceListFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PRICE_LIST = 'FACADE_PRICE_LIST';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addPriceListFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceListFacade(Container $container): Container
    {
        $container[static::FACADE_PRICE_LIST] = fn (Container $container): PriceProductPriceListGuiToPriceListFacadeBridge => new PriceProductPriceListGuiToPriceListFacadeBridge(
            $container->getLocator()->priceList()->facade(),
        );

        return $container;
    }
}
