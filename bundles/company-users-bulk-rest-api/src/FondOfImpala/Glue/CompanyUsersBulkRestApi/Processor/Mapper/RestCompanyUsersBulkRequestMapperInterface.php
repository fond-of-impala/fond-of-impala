<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface RestCompanyUsersBulkRequestMapperInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer|null $restCompanyUsersBulkRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer
     */
    public function createRequest(
        RestRequestInterface $restRequest,
        ?RestCompanyUsersBulkRequestAttributesTransfer $restCompanyUsersBulkRequestAttributesTransfer = null
    ): RestCompanyUsersBulkRequestTransfer;
}
