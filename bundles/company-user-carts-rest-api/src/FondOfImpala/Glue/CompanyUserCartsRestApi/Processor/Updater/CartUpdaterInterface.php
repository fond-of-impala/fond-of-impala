<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Updater;

use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface CartUpdaterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function update(
        RestRequestInterface $restRequest,
        RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
    ): RestResponseInterface;
}
