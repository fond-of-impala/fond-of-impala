<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension\TypePriceProductAbstractPriceListPageSearchDataExpanderPlugin;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension\TypePriceProductConcretePriceListPageSearchDataExpanderPlugin;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeBridge;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceBridge;
use Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_PRICE_PRODUCT_PRICE_LIST = 'PROPEL_QUERY_PRICE_PRODUCT_PRICE_LIST';

    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER = 'PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER = 'PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_DATA_EXPANDER = 'PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_DATA_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_DATA_EXPANDER = 'PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_DATA_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addUtilEncodingService($container);
        $container = $this->addStoreFacade($container);

        $container = $this->addPriceProductAbstractPriceListPageSearchDataExpanderPlugins($container);
        $container = $this->addPriceProductConcretePriceListPageSearchDataExpanderPlugins($container);

        $container = $this->addPriceProductAbstractPriceListPageDataExpanderPlugins($container);
        $container = $this->addPriceProductConcretePriceListPageDataExpanderPlugins($container);

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

        $container = $this->addPropelPriceProductPriceListQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviorFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT_BEHAVIOR] = static function (Container $container) {
            return new PriceProductPriceListPageSearchToEventBehaviorFacadeBridge(
                $container->getLocator()->eventBehavior()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPropelPriceProductPriceListQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PRICE_PRODUCT_PRICE_LIST] = static function () {
            return FoiPriceProductPriceListQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = static function (Container $container) {
            return new PriceProductPriceListPageSearchToStoreFacadeBridge(
                $container->getLocator()->store()->facade(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_ENCODING] = static function (Container $container) {
            return new PriceProductPriceListPageSearchToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductAbstractPriceListPageSearchDataExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER] = static function () use ($self) {
            return $self->getPriceProductAbstractPriceListPageSearchDataExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface[]
     */
    protected function getPriceProductAbstractPriceListPageSearchDataExpanderPlugins(): array
    {
        return [
            new TypePriceProductAbstractPriceListPageSearchDataExpanderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductConcretePriceListPageSearchDataExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER] = static function () use ($self) {
            return $self->getPriceProductConcretePriceListPageSearchDataExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageSearchDataExpanderPluginInterface[]
     */
    protected function getPriceProductConcretePriceListPageSearchDataExpanderPlugins(): array
    {
        return [
            new TypePriceProductConcretePriceListPageSearchDataExpanderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductAbstractPriceListPageDataExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_DATA_EXPANDER] = static function () use ($self) {
            return $self->getPriceProductAbstractPriceListPageDataExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface[]
     */
    protected function getPriceProductAbstractPriceListPageDataExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductConcretePriceListPageDataExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_DATA_EXPANDER] = static function () use ($self) {
            return $self->getPriceProductConcretePriceListPageDataExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface[]
     */
    protected function getPriceProductConcretePriceListPageDataExpanderPlugins(): array
    {
        return [];
    }
}
