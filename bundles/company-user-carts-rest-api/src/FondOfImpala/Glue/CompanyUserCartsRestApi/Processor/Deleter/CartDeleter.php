<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Deleter;

use FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartDeleter implements CartDeleterInterface
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface
     */
    protected $restCompanyUserCartsRequestMapper;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected $restResponseBuilder;

    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface
     */
    protected $client;

    /**
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface $restCompanyUserCartsRequestMapper
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface $client
     */
    public function __construct(
        RestCompanyUserCartsRequestMapperInterface $restCompanyUserCartsRequestMapper,
        RestResponseBuilderInterface $restResponseBuilder,
        CompanyUserCartsRestApiClientInterface $client
    ) {
        $this->restCompanyUserCartsRequestMapper = $restCompanyUserCartsRequestMapper;
        $this->restResponseBuilder = $restResponseBuilder;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function delete(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restCompanyUserCartsRequestTransfer = $this->restCompanyUserCartsRequestMapper->fromRestRequest($restRequest);

        $restCompanyUserCartsResponseTransfer = $this->client->deleteQuoteByRestCompanyUserCartsRequest(
            $restCompanyUserCartsRequestTransfer,
        );

        if (!$restCompanyUserCartsResponseTransfer->getIsSuccessful()) {
            $quoteErrorTransfers = $restCompanyUserCartsResponseTransfer->getErrors()
                ->getArrayCopy();

            return $this->restResponseBuilder->buildErrorRestResponse($quoteErrorTransfers);
        }

        return $this->restResponseBuilder->buildEmptyRestResponse();
    }
}
