<?php

namespace FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Facade\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_CURRENCY = 'FACADE_CURRENCY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addCurrencyFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCurrencyFacade(Container $container): Container
    {
        $container[static::FACADE_CURRENCY] = static fn(): PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge => new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge($container->getLocator()->currency()->facade());

        return $container;
    }
}
