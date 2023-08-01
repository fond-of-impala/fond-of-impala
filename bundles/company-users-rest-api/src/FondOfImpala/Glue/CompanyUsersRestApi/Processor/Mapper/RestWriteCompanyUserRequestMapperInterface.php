<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface RestWriteCompanyUserRequestMapperInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer
     */
    public function fromRestRequest(RestRequestInterface $restRequest): RestWriteCompanyUserRequestTransfer;
}
