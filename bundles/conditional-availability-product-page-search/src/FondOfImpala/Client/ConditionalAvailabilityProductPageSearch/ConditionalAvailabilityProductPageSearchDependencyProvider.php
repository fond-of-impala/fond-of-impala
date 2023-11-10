<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch;

use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

/**
 * @method \Spryker\Client\Customer\CustomerConfig getConfig()
 */
class ConditionalAvailabilityProductPageSearchDependencyProvider extends AbstractDependencyProvider
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
    public function provideServiceLayerDependencies(Container $container)
    {
        $container = $this->addCustomerClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addCustomerClient(Container $container)
    {
        $container[static::CLIENT_CUSTOMER] = static fn (
            Container $container
        ): ConditionalAvailabilityProductPageSearchToCustomerClientBridge => new ConditionalAvailabilityProductPageSearchToCustomerClientBridge(
            $container->getLocator()->customer()->client(),
        );

        return $container;
    }
}
