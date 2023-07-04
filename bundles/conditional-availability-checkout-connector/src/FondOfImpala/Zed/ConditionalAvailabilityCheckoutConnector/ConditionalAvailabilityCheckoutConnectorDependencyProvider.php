<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector;

use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge;
use Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery as BaseSpyCustomerQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
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
    public const FACADE_CONDITIONAL_AVAILABILITY = 'FACADE_CONDITIONAL_AVAILABILITY';

    /**
     * @var string
     */
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';

    /**
     * @var string
     */
    public const SERVICE_CONDITIONAL_AVAILABILITY = 'SERVICE_CONDITIONAL_AVAILABILITY';

    /**
     * @var string
     */
    public const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addConditionalAvailabilityFacade($container);
        $container = $this->addCustomerFacade($container);

        return $this->addConditionalAvailabilityService($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityFacade(Container $container): Container
    {
        $container[static::FACADE_CONDITIONAL_AVAILABILITY] = static fn (
            Container $container
        ): ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridge => new ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridge(
            $container->getLocator()->conditionalAvailability()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityService(Container $container): Container
    {
        $container[static::SERVICE_CONDITIONAL_AVAILABILITY] = static fn (
            Container $container
        ): ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge => new ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge(
            $container->getLocator()->conditionalAvailability()->service(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerFacade(Container $container): Container
    {
        $container[static::FACADE_CUSTOMER] = static fn (
            Container $container
        ): ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface => new ConditionalAvailabilityCheckoutConnectorToCustomerFacadeBridge(
            $container->getLocator()->customer()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addCustomerQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_CUSTOMER] = static fn (): BaseSpyCustomerQuery => SpyCustomerQuery::create();

        return $container;
    }
}
