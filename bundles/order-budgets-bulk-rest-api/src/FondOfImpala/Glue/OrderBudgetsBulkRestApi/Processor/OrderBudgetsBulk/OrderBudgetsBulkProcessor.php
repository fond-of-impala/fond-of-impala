<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk;

use FondOfImpala\Client\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiClientInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestMapperInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class OrderBudgetsBulkProcessor implements OrderBudgetsBulkProcessorInterface
{
    protected CustomerReferenceFilterInterface $customerReferenceFilter;

    protected RestOrderBudgetsBulkRequestMapperInterface $restOrderBudgetsBulkRequestMapper;

    protected RestResponseBuilderInterface $restResponseBuilder;

    protected OrderBudgetsBulkRestApiClientInterface $client;

    /**
     * @param \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface $customerReferenceFilter
     * @param \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestMapperInterface $restOrderBudgetsBulkRequestMapper
     * @param \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfImpala\Client\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiClientInterface $client
     */
    public function __construct(
        CustomerReferenceFilterInterface $customerReferenceFilter,
        RestOrderBudgetsBulkRequestMapperInterface $restOrderBudgetsBulkRequestMapper,
        RestResponseBuilderInterface $restResponseBuilder,
        OrderBudgetsBulkRestApiClientInterface $client
    ) {
        $this->customerReferenceFilter = $customerReferenceFilter;
        $this->restOrderBudgetsBulkRequestMapper = $restOrderBudgetsBulkRequestMapper;
        $this->restResponseBuilder = $restResponseBuilder;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function process(
        RestRequestInterface $restRequest,
        RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
    ): RestResponseInterface {
        $restOrderBudgetsBulkRequestTransfer = $this->restOrderBudgetsBulkRequestMapper
            ->fromRestOrderBudgetsBulkRequestAttributes($restOrderBudgetsBulkRequestAttributesTransfer)
            ->setCustomerReference($this->customerReferenceFilter->filterFromRestRequest($restRequest));

        $restOrderBudgetsBulkResponseTransfer = $this->client->bulkProcess($restOrderBudgetsBulkRequestTransfer);

        return $this->restResponseBuilder->buildRestResponseByRestOrderBudgetsBulkResponse(
            $restOrderBudgetsBulkResponseTransfer,
        );
    }
}
