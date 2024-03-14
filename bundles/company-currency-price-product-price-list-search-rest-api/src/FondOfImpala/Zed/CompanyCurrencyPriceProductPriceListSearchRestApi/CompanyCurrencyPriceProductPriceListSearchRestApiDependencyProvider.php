<?php

namespace FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi;

use FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Facade\CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider extends AbstractBundleDependencyProvider
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
        $container[static::FACADE_CURRENCY] = static fn (): CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeBridge => new CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeBridge($container->getLocator()->currency()->facade());

        return $container;
    }
}
