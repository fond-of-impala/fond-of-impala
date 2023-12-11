<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig getConfig()
 */
class ConditionalAvailabilityProductPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const FACADE_PRODUCT = 'FACADE_PRODUCT';

    /**
     * @var string
     */
    public const FACADE_CONDITIONAL_AVAILABILITY = 'FACADE_CONDITIONAL_AVAILABILITY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addConditionalAvailabilityFacade($container);
        $container = $this->addEventBehaviorFacade($container);

        return $this->addProductFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviorFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT_BEHAVIOR] = static fn (
            Container $container
        ): ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface => new ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridge(
            $container->getLocator()->eventBehavior()->facade(),
        );

        return $container;
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
        ): ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface => new ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeBridge(
            $container->getLocator()->conditionalAvailability()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT] = static fn (
            Container $container
        ): ConditionalAvailabilityProductPageSearchToProductFacadeInterface => new ConditionalAvailabilityProductPageSearchToProductFacadeBridge(
            $container->getLocator()->product()->facade(),
        );

        return $container;
    }
}
