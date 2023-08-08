<?php

namespace FondOfImpala\Zed\CompanyPriceListGui;

use FondOfImpala\Zed\CompanyPriceListGui\Dependency\Facade\CompanyPriceListGuiToPriceListFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyPriceListGuiDependencyProvider extends AbstractBundleDependencyProvider
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
        $container[static::FACADE_PRICE_LIST] = fn (Container $container): CompanyPriceListGuiToPriceListFacadeBridge => new CompanyPriceListGuiToPriceListFacadeBridge(
            $container->getLocator()->priceList()->facade(),
        );

        return $container;
    }
}
