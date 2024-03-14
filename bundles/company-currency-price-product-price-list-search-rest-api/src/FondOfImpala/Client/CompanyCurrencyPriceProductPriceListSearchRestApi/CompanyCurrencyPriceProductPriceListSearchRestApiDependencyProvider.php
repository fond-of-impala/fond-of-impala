<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi;

use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider extends AbstractDependencyProvider
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
        $container[static::CLIENT_ZED_REQUEST] = static fn (Container $container): CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientBridge => new CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientBridge(
            $container->getLocator()->zedRequest()->client(),
        );

        return $container;
    }
}
