<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi;

use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder\RestResponseBuilder;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter\CustomerReferenceFilter;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentMapper;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentMapperInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentProductListsMapper;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentProductListsMapperInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestMapper;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestMapperInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk\ProductListsBulkProcessor;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk\ProductListsBulkProcessorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\ProductListsBulkRestApi\ProductListsBulkRestApiClientInterface getClient()
 */
class ProductListsBulkRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk\ProductListsBulkProcessorInterface
     */
    public function createProductListsBulkProcessor(): ProductListsBulkProcessorInterface
    {
        return new ProductListsBulkProcessor(
            $this->createCustomerReferenceFilter(),
            $this->createRestProductListsBulkRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestMapperInterface
     */
    protected function createRestProductListsBulkRequestMapper(): RestProductListsBulkRequestMapperInterface
    {
        return new RestProductListsBulkRequestMapper(
            $this->createRestProductListsBulkRequestAssignmentMapper(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentMapperInterface
     */
    protected function createRestProductListsBulkRequestAssignmentMapper(): RestProductListsBulkRequestAssignmentMapperInterface
    {
        return new RestProductListsBulkRequestAssignmentMapper(
            $this->createRestProductListsBulkRequestAssignmentProductListsMapper(),
            $this->getRestProductListsBulkRequestAssignmentMapperPlugins(),
        );
    }

    /**
     * @return array<\FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface>
     */
    protected function getRestProductListsBulkRequestAssignmentMapperPlugins(): array
    {
        return $this->getProvidedDependency(ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_MAPPER);
    }

    /**
     * @return \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentProductListsMapperInterface
     */
    protected function createRestProductListsBulkRequestAssignmentProductListsMapper(): RestProductListsBulkRequestAssignmentProductListsMapperInterface
    {
        return new RestProductListsBulkRequestAssignmentProductListsMapper();
    }

    /**
     * @return \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface
     */
    protected function createCustomerReferenceFilter(): CustomerReferenceFilterInterface
    {
        return new CustomerReferenceFilter();
    }

    /**
     * @return \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected function createRestResponseBuilder(): RestResponseBuilderInterface
    {
        return new RestResponseBuilder(
            $this->getResourceBuilder(),
        );
    }
}
