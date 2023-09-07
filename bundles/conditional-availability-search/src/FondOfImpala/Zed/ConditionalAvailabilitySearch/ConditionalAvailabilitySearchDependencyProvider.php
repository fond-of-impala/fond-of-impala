<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch;

use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductPageSearchFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductPageSearchFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilitySearch\ConditionalAvailabilitySearchConfig getConfig()
 */
class ConditionalAvailabilitySearchDependencyProvider extends AbstractBundleDependencyProvider
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
    public const FACADE_PRODUCT_PAGE_SEARCH = 'FACADE_PRODUCT_PAGE_SEARCH';

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
        $container = $this->addProductFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addEventBehaviorFacade($container);
        $container = $this->addProductPageSearchFacade($container);
        $container = $this->addConditionalAvailabilityFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviorFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT_BEHAVIOR] = static fn(
            Container $container
        ): ConditionalAvailabilitySearchToEventBehaviorFacadeBridge => new ConditionalAvailabilitySearchToEventBehaviorFacadeBridge(
            $container->getLocator()->eventBehavior()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductPageSearchFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT_PAGE_SEARCH] = static fn(
            Container $container
        ): ConditionalAvailabilitySearchToProductPageSearchFacadeInterface => new ConditionalAvailabilitySearchToProductPageSearchFacadeBridge(
            $container->getLocator()->productPageSearch()->facade(),
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
        $container[static::FACADE_CONDITIONAL_AVAILABILITY] = static fn(
            Container $container
        ): ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface => new ConditionalAvailabilitySearchToConditionalAvailabilityFacadeBridge(
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
        $container[static::FACADE_PRODUCT] = static fn(
            Container $container
        ): ConditionalAvailabilitySearchToProductFacadeInterface => new ConditionalAvailabilitySearchToProductFacadeBridge(
            $container->getLocator()->product()->facade(),
        );

        return $container;
    }
}
