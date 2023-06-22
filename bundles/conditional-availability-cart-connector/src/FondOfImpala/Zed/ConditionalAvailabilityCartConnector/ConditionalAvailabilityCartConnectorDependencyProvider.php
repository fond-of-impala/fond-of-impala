<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityCartConnectorDependencyProvider extends AbstractBundleDependencyProvider
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
    public const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';

    /**
     * @var string
     */
    public const SERVICE_CONDITIONAL_AVAILABILITY = 'SERVICE_CONDITIONAL_AVAILABILITY';

    /**
     * @var string
     */
    public const SERVICE = 'SERVICE';

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
        $container = $this->addConditionalAvailabilityService($container);
        $container = $this->addService($container);

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

        $container = $this->addCustomerPropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityFacade(Container $container): Container
    {
        $container[static::FACADE_CONDITIONAL_AVAILABILITY] = static function (Container $container) {
            return new ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge(
                $container->getLocator()->conditionalAvailability()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerFacade(Container $container): Container
    {
        $container[static::FACADE_CUSTOMER] = static function (Container $container) {
            return new ConditionalAvailabilityCartConnectorToCustomerFacadeBridge(
                $container->getLocator()->customer()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityService(Container $container): Container
    {
        $container[static::SERVICE_CONDITIONAL_AVAILABILITY] = static function (Container $container) {
            return new ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge(
                $container->getLocator()->conditionalAvailability()->service(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addService(Container $container): Container
    {
        $container[static::SERVICE] = static function (Container $container) {
            return $container->getLocator()->conditionalAvailabilityCartConnector()->service();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_CUSTOMER] = static function () {
            return SpyCustomerQuery::create();
        };

        return $container;
    }
}
