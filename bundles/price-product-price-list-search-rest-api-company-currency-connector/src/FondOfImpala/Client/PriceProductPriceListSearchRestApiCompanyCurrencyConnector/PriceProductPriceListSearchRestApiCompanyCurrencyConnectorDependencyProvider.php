<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_ZED_REQUEST = 'CLIENT_ZED_REQUEST';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addZedRequestClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addZedRequestClient(Container $container): Container
    {
        $container[static::CLIENT_ZED_REQUEST] = static fn (Container $container): PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientBridge => new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientBridge(
            $container->getLocator()->zedRequest()->client(),
        );

        return $container;
    }
}
