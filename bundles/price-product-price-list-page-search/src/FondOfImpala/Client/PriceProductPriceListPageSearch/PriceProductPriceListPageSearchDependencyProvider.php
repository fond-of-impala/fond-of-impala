<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch;

use FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientBridge;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\PriceProductAbstractPriceListSearchQueryPlugin;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\PriceProductConcretePriceListSearchQueryPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @codeCoverageIgnore
 */
class PriceProductPriceListPageSearchDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    /**
     * @var string
     */
    public const PLUGIN_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY = 'PLUGIN_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY';

    /**
     * @var string
     */
    public const PLUGIN_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY = 'PLUGIN_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_COUNT_QUERY_EXPANDER = 'PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_COUNT_QUERY_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_RESULT_FORMATTER = 'PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_RESULT_FORMATTER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY_EXPANDER = 'PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_COUNT_QUERY_EXPANDER = 'PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_COUNT_QUERY_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_RESULT_FORMATTER = 'PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_RESULT_FORMATTER';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY_EXPANDER = 'PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY_EXPANDER';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addSearchClient($container);

        $container = $this->addPriceProductAbstractPriceListSearchQueryPlugin($container);
        $container = $this->addPriceProductAbstractPriceListSearchResultFormatterPlugins($container);
        $container = $this->addPriceProductAbstractPriceListSearchQueryExpanderPlugins($container);
        $container = $this->addPriceProductAbstractPriceListSearchCountQueryExpanderPlugins($container);

        $container = $this->addPriceProductConcretePriceListSearchQueryPlugin($container);
        $container = $this->addPriceProductConcretePriceListSearchResultFormatterPlugins($container);
        $container = $this->addPriceProductConcretePriceListSearchQueryExpanderPlugins($container);
        $container = $this->addPriceProductConcretePriceListSearchQueryCountExpanderPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSearchClient(Container $container): Container
    {
        $container[static::CLIENT_SEARCH] = static fn(Container $container): PriceProductPriceListPageSearchToSearchClientBridge => new PriceProductPriceListPageSearchToSearchClientBridge(
            $container->getLocator()->search()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductAbstractPriceListSearchQueryPlugin(Container $container): Container
    {
        $container[static::PLUGIN_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY] = fn (): QueryInterface => $this->createPriceProductAbstractPriceListSearchQueryPlugin();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductAbstractPriceListSearchResultFormatterPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_RESULT_FORMATTER] = fn (): array => $this->createPriceProductAbstractPriceListSearchResultFormatterPlugins();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductAbstractPriceListSearchQueryExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY_EXPANDER] = fn (): array => $this->createPriceProductAbstractPriceListSearchQueryExpanderPlugins();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductAbstractPriceListSearchCountQueryExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_COUNT_QUERY_EXPANDER] = fn (): array => $this->createPriceProductAbstractPriceListSearchCountQueryExpanderPlugins();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductConcretePriceListSearchQueryPlugin(Container $container): Container
    {
        $container[static::PLUGIN_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY] = fn (): QueryInterface => $this->createPriceProductConcretePriceListSearchQueryPlugin();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductConcretePriceListSearchResultFormatterPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_RESULT_FORMATTER] = fn (): array => $this->createPriceProductConcretePriceListSearchResultFormatterPlugins();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductConcretePriceListSearchQueryExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY_EXPANDER] = fn (): array => $this->createPriceProductConcretePriceListSearchQueryExpanderPlugins();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addPriceProductConcretePriceListSearchQueryCountExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY_EXPANDER] = fn (): array => $this->createPriceProductConcretePriceListSearchCountQueryExpanderPlugins();

        return $container;
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected function createPriceProductAbstractPriceListSearchQueryPlugin(): QueryInterface
    {
        return new PriceProductAbstractPriceListSearchQueryPlugin();
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected function createPriceProductConcretePriceListSearchQueryPlugin(): QueryInterface
    {
        return new PriceProductConcretePriceListSearchQueryPlugin();
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function createPriceProductAbstractPriceListSearchResultFormatterPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createPriceProductAbstractPriceListSearchQueryExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createPriceProductAbstractPriceListSearchCountQueryExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function createPriceProductConcretePriceListSearchResultFormatterPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createPriceProductConcretePriceListSearchQueryExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createPriceProductConcretePriceListSearchCountQueryExpanderPlugins(): array
    {
        return [];
    }
}
