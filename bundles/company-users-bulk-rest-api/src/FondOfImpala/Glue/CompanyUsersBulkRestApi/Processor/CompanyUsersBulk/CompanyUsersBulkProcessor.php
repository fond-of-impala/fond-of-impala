<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk;

use FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapperInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersBulkProcessor implements CompanyUsersBulkProcessorInterface
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapperInterface
     */
    protected RestCompanyUsersBulkRequestMapperInterface $restCompanyUsersBulkRequestMapper;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected RestResponseBuilderInterface $restResponseBuilder;

    /**
     * @var \FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClientInterface
     */
    protected CompanyUsersBulkRestApiClientInterface $client;

    /**
     * @param \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapperInterface $restCompanyUsersBulkRequestMapper
     * @param \FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClientInterface $client
     * @param \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     */
    public function __construct(
        RestCompanyUsersBulkRequestMapperInterface $restCompanyUsersBulkRequestMapper,
        CompanyUsersBulkRestApiClientInterface $client,
        RestResponseBuilderInterface $restResponseBuilder
    ) {
        $this->restCompanyUsersBulkRequestMapper = $restCompanyUsersBulkRequestMapper;
        $this->client = $client;
        $this->restResponseBuilder = $restResponseBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer $restCompanyUsersBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function process(
        RestRequestInterface $restRequest,
        RestCompanyUsersBulkRequestAttributesTransfer $restCompanyUsersBulkRequestAttributesTransfer
    ): RestResponseInterface {
        $restCompanyUsersBulkRequestTransfer = $this->restCompanyUsersBulkRequestMapper
            ->createRequest($restRequest, $restCompanyUsersBulkRequestAttributesTransfer);

        $response = $this->client->bulkProcess($restCompanyUsersBulkRequestTransfer);

        if ($response->getError() !== null) {
            return $this->restResponseBuilder
                ->createRestErrorResponse($response->getError(), $response->getCode());
        }

        return $this->restResponseBuilder->buildEmptyRestResponse();
    }
}
