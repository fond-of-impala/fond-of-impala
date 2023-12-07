<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceBridge;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_DATA_EXPANDER = 'PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_DATA_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_SEARCH_DATA_EXPANDER = 'PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_SEARCH_DATA_EXPANDER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_CONDITIONAL_AVAILABILITY_PERIOD = 'PROPEL_QUERY_CONDITIONAL_AVAILABILITY_PERIOD';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addConditionalAvailabilityPeriodPageDataExpanderPlugins($container);
        $container = $this->addConditionalAvailabilityPeriodPageSearchDataExpanderPlugins($container);

        return $this->addUtilEncodingService($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addConditionalAvailabilityPeriodPropelQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityPeriodPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_CONDITIONAL_AVAILABILITY_PERIOD] = static fn (): FoiConditionalAvailabilityPeriodQuery => FoiConditionalAvailabilityPeriodQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_ENCODING] = static fn (
            Container $container
        ): ConditionalAvailabilityPageSearchToUtilEncodingServiceBridge => new ConditionalAvailabilityPageSearchToUtilEncodingServiceBridge(
            $container->getLocator()->utilEncoding()->service(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityPeriodPageSearchDataExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_SEARCH_DATA_EXPANDER] = static fn (): array => $self->getConditionalAvailabilityPeriodPageSearchDataExpanderPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface>
     */
    protected function getConditionalAvailabilityPeriodPageSearchDataExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityPeriodPageDataExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_DATA_EXPANDER] = static fn (): array => $self->getConditionalAvailabilityPeriodPageDataExpanderPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface>
     */
    protected function getConditionalAvailabilityPeriodPageDataExpanderPlugins(): array
    {
        return [];
    }
}
