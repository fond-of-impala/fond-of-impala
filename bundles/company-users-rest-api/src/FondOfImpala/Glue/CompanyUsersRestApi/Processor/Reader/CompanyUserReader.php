<?php

declare(strict_types = 1);

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader;

use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserReader implements CompanyUserReaderInterface
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
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    protected $companyUserMapper;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiError;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface
     */
    protected $companyUserReferenceClient;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $client
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface $companyUserReferenceClient
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface $companyUserMapper
     * @param \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiClientInterface $client,
        CompanyUsersRestApiToCompanyUserReferenceClientInterface $companyUserReferenceClient,
        CompanyUsersMapperInterface $companyUserMapper,
        RestApiErrorInterface $restApiError
    ) {
        $this->client = $client;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyUserMapper = $companyUserMapper;
        $this->restApiError = $restApiError;
        $this->companyUserReferenceClient = $companyUserReferenceClient;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findCurrentCompanyUsers(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        $user = $restRequest->getRestUser();

        if ($user === null) {
            return $this->restApiError->addAccessDeniedError($restResponse);
        }

        $customerTransfer = (new CustomerTransfer())->setCustomerReference($user->getNaturalIdentifier());

        $companyUserCollectionTransfer = $this->client
            ->findActiveCompanyUsersByCustomerReference($customerTransfer);

        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUser) {
            $resource = $this->companyUserMapper
                ->mapCompanyUsersResource($companyUser)
                ->setPayload($companyUser);

            $restResponse->addResource($resource);
        }

        return $restResponse;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findCompanyUser(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        $user = $restRequest->getRestUser();

        if ($user === null) {
            return $this->restApiError->addAccessDeniedError($restResponse);
        }

        $companyUserReference = $restRequest->getResource()->getId();
        $companyUserResponseTransfer = $this->companyUserReferenceClient->findCompanyUserByCompanyUserReference(
            (new CompanyUserTransfer())->setCompanyUserReference($companyUserReference),
        );

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if (
            $companyUserTransfer === null
            || !$companyUserResponseTransfer->getIsSuccessful()
            || $companyUserTransfer->getFkCustomer() !== $user->getSurrogateIdentifier()
        ) {
            return $this->restApiError->addCompanyUserNotFoundError($restResponse);
        }

        $resource = $this->companyUserMapper
            ->mapCompanyUsersResource($companyUserTransfer)
            ->setPayload($companyUserTransfer);

        return $restResponse->addResource($resource);
    }
}
