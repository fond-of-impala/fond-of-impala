<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface RestDeleteCompanyUserRequestMapperInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer
     */
    public function fromRestRequest(RestRequestInterface $restRequest): RestDeleteCompanyUserRequestTransfer;
}
