<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings;

use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface CustomerUpdaterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function updateCustomer(
        RestRequestInterface $restRequest,
        RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
    ): RestResponseInterface;
}
