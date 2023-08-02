<?php

declare(strict_types = 1);

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator;

use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserCreator implements CompanyUserCreatorInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $client;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiError;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $companyUsersRestApiClient
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiClientInterface $companyUsersRestApiClient,
        RestApiErrorInterface $restApiError
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->client = $companyUsersRestApiClient;
        $this->restApiError = $restApiError;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function create(
        RestRequestInterface $restRequest,
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestResponseInterface {
        $restUser = $restRequest->getRestUser();

        if ($restUser === null || $restUser->getSurrogateIdentifier() === null) {
            return $this->restApiError->addAccessDeniedError($this->restResourceBuilder->createRestResponse());
        }

        $restCustomerTransfer = (new RestCustomerTransfer())
            ->setIdCustomer($restUser->getSurrogateIdentifier());

        $restCompanyUsersRequestAttributesTransfer->setCurrentCustomer($restCustomerTransfer);

        $restCompanyUsersResponseTransfer = $this->client->create(
            $restCompanyUsersRequestAttributesTransfer,
        );

        if (!$restCompanyUsersResponseTransfer->getIsSuccess()) {
            return $this->createSaveCompanyUserFailedErrorResponse($restCompanyUsersResponseTransfer);
        }

        return $this->createCompanyUserSavedResponse($restCompanyUsersResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createSaveCompanyUserFailedErrorResponse(
        RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        foreach ($restCompanyUsersResponseTransfer->getErrors() as $restCompanyUsersErrorTransfer) {
            $restResponse->addError((new RestErrorMessageTransfer())
                ->setCode($restCompanyUsersErrorTransfer->getCode())
                ->setStatus($restCompanyUsersErrorTransfer->getStatus())
                ->setDetail($restCompanyUsersErrorTransfer->getDetail()));
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createCompanyUserSavedResponse(RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer): RestResponseInterface
    {
        /** @var \Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer $restCompanyUsersResponseAttributesTransfer */
        $restCompanyUsersResponseAttributesTransfer = $restCompanyUsersResponseTransfer->getRestCompanyUsersResponseAttributes();

        $restResource = $this->restResourceBuilder->createRestResource(
            CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS,
            $restCompanyUsersResponseAttributesTransfer->getCompanyUserReference(),
            $restCompanyUsersResponseAttributesTransfer,
        )->setPayload($restCompanyUsersResponseTransfer->getCompanyUser());

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addResource($restResource);
    }
}
