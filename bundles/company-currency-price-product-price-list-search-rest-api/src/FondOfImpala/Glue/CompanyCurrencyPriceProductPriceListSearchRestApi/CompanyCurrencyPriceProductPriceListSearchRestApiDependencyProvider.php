<?php

namespace FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi;

use FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        return $this->addCustomerClient($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container[static::CLIENT_CUSTOMER] = static fn (
            Container $container
        ): CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientBridge => new CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientBridge(
            $container->getLocator()->customer()->client(),
        );

        return $container;
    }
}
