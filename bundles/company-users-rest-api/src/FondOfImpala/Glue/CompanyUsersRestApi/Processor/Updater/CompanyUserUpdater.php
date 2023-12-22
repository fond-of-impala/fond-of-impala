<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater;

use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserUpdater implements CompanyUserUpdaterInterface
{
    protected RestWriteCompanyUserRequestMapperInterface $restWriteCompanyUserRequestMapper;

    protected RestResponseBuilderInterface $restResponseBuilder;

    protected CompanyUsersRestApiClientInterface $client;

    /**
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface $restWriteCompanyUserRequestMapper
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $client
     */
    public function __construct(
        RestWriteCompanyUserRequestMapperInterface $restWriteCompanyUserRequestMapper,
        RestResponseBuilderInterface $restResponseBuilder,
        CompanyUsersRestApiClientInterface $client
    ) {
        $this->restWriteCompanyUserRequestMapper = $restWriteCompanyUserRequestMapper;
        $this->restResponseBuilder = $restResponseBuilder;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function update(
        RestRequestInterface $restRequest,
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestResponseInterface {
        $restWriteCompanyUserRequestTransfer = $this->restWriteCompanyUserRequestMapper->fromRestRequest($restRequest)
            ->setRestCompanyUsersRequestAttributes($restCompanyUsersRequestAttributesTransfer);

        $restWriteCompanyUserResponseTransfer = $this->client->updateCompanyUserByRestDeleteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer,
        );

        $companyUserTransfer = $restWriteCompanyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || $restWriteCompanyUserResponseTransfer->getIsSuccess() !== true) {
            return $this->restResponseBuilder->buildCouldNotUpdateCompanyUserRestResponse();
        }

        return $this->restResponseBuilder->buildRestResponse($companyUserTransfer);
    }
}
