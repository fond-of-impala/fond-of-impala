<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch;

use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridge;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class ProductListConditionalAvailabilityPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const FACADE_CONDITIONAL_AVAILABILITY = 'FACADE_CONDITIONAL_AVAILABILITY';

    /**
     * @var string
     */
    public const FACADE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH = 'FACADE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH';

    /**
     * @var string
     */
    public const FACADE_PRODUCT_LIST = 'FACADE_PRODUCT_LIST';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addProductListFacade($container);
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
        $container = $this->addConditionalAvailabilityFacade($container);

        return $this->addConditionalAvailabilityPageSearchFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductListFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT_LIST] = static fn (
            Container $container
        ): ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface => new ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge(
            $container->getLocator()->productList()->facade(),
        );

        return $container;
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
        ): ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface => new ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge(
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
        ): ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface => new ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge(
            $container->getLocator()->conditionalAvailability()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityPageSearchFacade(Container $container): Container
    {
        $container[static::FACADE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH] = static fn (
            Container $container
        ): ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface => new ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridge(
            $container->getLocator()->conditionalAvailabilityPageSearch()->facade(),
        );

        return $container;
    }
}
