<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp;

use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface CustomerUpdaterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function updateCustomer(
        RestRequestInterface $restRequest,
        RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
    ): RestResponseInterface;
}
