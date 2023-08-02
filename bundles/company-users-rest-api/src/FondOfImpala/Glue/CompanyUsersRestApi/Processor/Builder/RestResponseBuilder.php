<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder;

use FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilder implements RestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildEmptyRestResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse();
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildCouldNotDeleteCompanyUserRestResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COULD_NOT_DELETE_COMPANY_USER)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAIL_COULD_NOT_DELETE_COMPANY_USER);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildCouldNotUpdateCompanyUserRestResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COULD_NOT_UPDATE_COMPANY_USER)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAIL_COULD_NOT_UPDATE_COMPANY_USER);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildRestResponse(CompanyUserTransfer $companyUserTransfer): RestResponseInterface
    {
        $restCompanyUsersResponseAttributesTransfer = (new RestCompanyUsersResponseAttributesTransfer())->fromArray(
            $companyUserTransfer->toArray(),
            true,
        );

        $restResource = $this->restResourceBuilder->createRestResource(
            CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS,
            $companyUserTransfer->getCompanyUserReference(),
            $restCompanyUsersResponseAttributesTransfer,
        )->setPayload($companyUserTransfer);

        return $this->restResourceBuilder->createRestResponse()
            ->addResource($restResource);
    }
}
