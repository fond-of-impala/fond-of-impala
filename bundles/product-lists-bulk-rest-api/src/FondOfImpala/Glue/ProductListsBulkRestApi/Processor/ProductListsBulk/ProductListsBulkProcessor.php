<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk;

use FondOfImpala\Client\ProductListsBulkRestApi\ProductListsBulkRestApiClientInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestMapperInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class ProductListsBulkProcessor implements ProductListsBulkProcessorInterface
{
    protected CustomerReferenceFilterInterface $customerReferenceFilter;

    protected RestProductListsBulkRequestMapperInterface $restProductListsBulkRequestMapper;

    protected RestResponseBuilderInterface $restResponseBuilder;

    protected ProductListsBulkRestApiClientInterface $client;

    /**
     * @param \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface $customerReferenceFilter
     * @param \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestMapperInterface $restProductListsBulkRequestMapper
     * @param \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfImpala\Client\ProductListsBulkRestApi\ProductListsBulkRestApiClientInterface $client
     */
    public function __construct(
        CustomerReferenceFilterInterface $customerReferenceFilter,
        RestProductListsBulkRequestMapperInterface $restProductListsBulkRequestMapper,
        RestResponseBuilderInterface $restResponseBuilder,
        ProductListsBulkRestApiClientInterface $client
    ) {
        $this->customerReferenceFilter = $customerReferenceFilter;
        $this->restProductListsBulkRequestMapper = $restProductListsBulkRequestMapper;
        $this->restResponseBuilder = $restResponseBuilder;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function process(
        RestRequestInterface $restRequest,
        RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
    ): RestResponseInterface {
        $restProductListsBulkRequestTransfer = $this->restProductListsBulkRequestMapper
            ->fromRestProductListsBulkRequestAttributes($restProductListsBulkRequestAttributesTransfer)
            ->setCustomerReference($this->customerReferenceFilter->filterFromRestRequest($restRequest));

        $restProductListsBulkResponseTransfer = $this->client->bulkProcess($restProductListsBulkRequestTransfer);

        return $this->restResponseBuilder->buildByRestProductListsBulkResponse($restProductListsBulkResponseTransfer);
    }
}
