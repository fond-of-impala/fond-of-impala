<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter;

use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface
     */
    protected $restDeleteCompanyUserRequestMapper;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected $restResponseBuilder;

    /**
     * @var \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $client;

    /**
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface $restDeleteCompanyUserRequestMapper
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $client
     */
    public function __construct(
        RestDeleteCompanyUserRequestMapperInterface $restDeleteCompanyUserRequestMapper,
        RestResponseBuilderInterface $restResponseBuilder,
        CompanyUsersRestApiClientInterface $client
    ) {
        $this->restDeleteCompanyUserRequestMapper = $restDeleteCompanyUserRequestMapper;
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
        $restDeleteCompanyUserRequestTransfer = $this->restDeleteCompanyUserRequestMapper->fromRestRequest($restRequest);

        $restDeleteCompanyUserResponseTransfer = $this->client->deleteCompanyUserByRestDeleteCompanyUserRequest(
            $restDeleteCompanyUserRequestTransfer,
        );

        if ($restDeleteCompanyUserResponseTransfer->getIsSuccess() === false) {
            return $this->restResponseBuilder->buildCouldNotDeleteCompanyUserRestResponse();
        }

        return $this->restResponseBuilder->buildEmptyRestResponse();
    }
}
