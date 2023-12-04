<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector;

use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityCheckoutConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_CONDITIONAL_AVAILABILITY_CART_CONNECTOR = 'FACADE_CONDITIONAL_AVAILABILITY_CART_CONNECTOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        return $this->addConditionalAvailabilityCartConnectorFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityCartConnectorFacade(Container $container): Container
    {
        $container[static::FACADE_CONDITIONAL_AVAILABILITY_CART_CONNECTOR] = static fn (
            Container $container
        ): ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeBridge => new ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityCartConnectorFacadeBridge(
            $container->getLocator()->conditionalAvailabilityCartConnector()->facade(),
        );

        return $container;
    }
}
