<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class ProductListsBulkRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_MAPPER = 'PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_MAPPER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        return $this->addRestProductListsBulkRequestAssignmentMapperPlugins($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addRestProductListsBulkRequestAssignmentMapperPlugins(Container $container): Container
    {
        $container[static::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_MAPPER] = fn (): array => $this->getRestProductListsBulkRequestAssignmentMapperPlugins();

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface>
     */
    protected function getRestProductListsBulkRequestAssignmentMapperPlugins(): array
    {
        return [];
    }
}
