<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface RestCompanyUserCartsRequestMapperInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer
     */
    public function fromRestRequest(RestRequestInterface $restRequest): RestCompanyUserCartsRequestTransfer;
}
