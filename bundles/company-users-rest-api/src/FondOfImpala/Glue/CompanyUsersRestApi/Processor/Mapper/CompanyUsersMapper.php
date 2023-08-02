<?php

declare(strict_types = 1);

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper;

use FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

class CompanyUsersMapper implements CompanyUsersMapperInterface
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
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function mapCompanyUsersResource(
        CompanyUserTransfer $companyUserTransfer
    ): RestResourceInterface {
        $restCompanyUsersResponseAttributesTransfer = new RestCompanyUsersResponseAttributesTransfer();

        $restCompanyUsersResponseAttributesTransfer->fromArray(
            $companyUserTransfer->toArray(),
            true,
        );

        $companyUsersResource = $this->restResourceBuilder->createRestResource(
            CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS,
            $companyUserTransfer->getCompanyUserReference(),
            $restCompanyUsersResponseAttributesTransfer,
        );

        $companyUsersResource->setPayload($companyUserTransfer);

        return $companyUsersResource;
    }
}
