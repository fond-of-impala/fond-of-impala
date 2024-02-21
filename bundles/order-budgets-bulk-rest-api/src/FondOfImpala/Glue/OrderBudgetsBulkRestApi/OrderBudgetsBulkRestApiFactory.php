<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi;

use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder\RestResponseBuilder;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter\CustomerReferenceFilter;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestMapper;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestMapperInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestOrderBudgetMapper;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestOrderBudgetMapperInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk\OrderBudgetsBulkProcessor;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk\OrderBudgetsBulkProcessorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiClientInterface getClient()
 */
class OrderBudgetsBulkRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk\OrderBudgetsBulkProcessorInterface
     */
    public function createOrderBudgetsBulkProcessor(): OrderBudgetsBulkProcessorInterface
    {
        return new OrderBudgetsBulkProcessor(
            $this->createCustomerReferenceFilter(),
            $this->createRestOrderBudgetsBulkRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestMapperInterface
     */
    protected function createRestOrderBudgetsBulkRequestMapper(): RestOrderBudgetsBulkRequestMapperInterface
    {
        return new RestOrderBudgetsBulkRequestMapper(
            $this->createRestOrderBudgetsBulkRequestAssignmentMapper(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestOrderBudgetMapperInterface
     */
    protected function createRestOrderBudgetsBulkRequestAssignmentMapper(): RestOrderBudgetsBulkRequestOrderBudgetMapperInterface
    {
        return new RestOrderBudgetsBulkRequestOrderBudgetMapper(
            $this->getRestOrderBudgetsBulkRequestOrderBudgetMapperPlugins(),
        );
    }

    /**
     * @return array<\FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface>
     */
    protected function getRestOrderBudgetsBulkRequestOrderBudgetMapperPlugins(): array
    {
        return $this->getProvidedDependency(
            OrderBudgetsBulkRestApiDependencyProvider::PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_ORDER_BUDGET_MAPPER,
        );
    }

    /**
     * @return \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface
     */
    protected function createCustomerReferenceFilter(): CustomerReferenceFilterInterface
    {
        return new CustomerReferenceFilter();
    }

    /**
     * @return \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected function createRestResponseBuilder(): RestResponseBuilderInterface
    {
        return new RestResponseBuilder(
            $this->getResourceBuilder(),
        );
    }
}
