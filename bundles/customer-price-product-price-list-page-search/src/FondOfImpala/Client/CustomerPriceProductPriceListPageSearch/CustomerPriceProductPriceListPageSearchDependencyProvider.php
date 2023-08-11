<?php

namespace FondOfImpala\Client\CustomerPriceProductPriceListPageSearch;

use FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\Dependency\Client\CustomerPriceProductPriceListPageSearchToCustomerClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class CustomerPriceProductPriceListPageSearchDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addCustomerClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container[static::CLIENT_CUSTOMER] = static fn (Container $container): CustomerPriceProductPriceListPageSearchToCustomerClientBridge => new CustomerPriceProductPriceListPageSearchToCustomerClientBridge(
            $container->getLocator()->customer()->client(),
        );

        return $container;
    }
}
