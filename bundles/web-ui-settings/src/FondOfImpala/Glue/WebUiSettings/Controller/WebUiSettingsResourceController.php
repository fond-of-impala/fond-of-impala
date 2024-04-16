<?php

namespace FondOfImpala\Glue\WebUiSettings\Controller;

use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\WebUiSettings\WebUiSettingsFactory getFactory()
 */
class WebUiSettingsResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patchAction(
        RestRequestInterface $restRequest,
        RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()->createCustomerUpdater()->updateCustomer($restRequest, $restWebUiSettingsRequestAttributesTransfer);
    }
}
