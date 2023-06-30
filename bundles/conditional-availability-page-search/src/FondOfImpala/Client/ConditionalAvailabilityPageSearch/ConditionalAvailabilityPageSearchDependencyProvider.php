<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch;

use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientBridge;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientBridge;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Plugin\SearchExtension\ConditionalAvailabilityPageSearchQueryPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityPageSearchDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @var string
     */
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    /**
     * @var string
     */
    public const PLUGIN_SEARCH_QUERY = 'PLUGIN_SEARCH_QUERY';

    /**
     * @var string
     */
    public const PLUGINS_SEARCH_QUERY_EXPANDER = 'PLUGINS_SEARCH_QUERY_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_SEARCH_RESULT_FORMATTER = 'PLUGINS_SEARCH_RESULT_FORMATTER';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addCustomerClient($container);
        $container = $this->addSearchClient($container);
        $container = $this->addSearchQueryPlugin($container);
        $container = $this->addQueryExpanderPlugins($container);

        return $this->addResultFormatterPlugins($container);
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container[static::CLIENT_CUSTOMER] = static fn (
            Container $container
        ): ConditionalAvailabilityPageSearchToCustomerClientBridge => new ConditionalAvailabilityPageSearchToCustomerClientBridge(
            $container->getLocator()->customer()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSearchClient(Container $container): Container
    {
        $container[static::CLIENT_SEARCH] = static fn (
            Container $container
        ): ConditionalAvailabilityPageSearchToSearchClientBridge => new ConditionalAvailabilityPageSearchToSearchClientBridge(
            $container->getLocator()->search()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSearchQueryPlugin(Container $container): Container
    {
        $container[static::PLUGIN_SEARCH_QUERY] = static fn (): ConditionalAvailabilityPageSearchQueryPlugin => new ConditionalAvailabilityPageSearchQueryPlugin();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addQueryExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_SEARCH_QUERY_EXPANDER] = static fn (): array => $self->getQueryExpanderPlugins();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addResultFormatterPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_SEARCH_RESULT_FORMATTER] = static fn (): array => $self->getResultFormatterPlugins();

        return $container;
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function getQueryExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function getResultFormatterPlugins(): array
    {
        return [];
    }
}
