<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Controller;

use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\CustomerAppRestApi\CustomerAppRestApiFactory getFactory()
 */
class CustomerAppResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patchAction(
        RestRequestInterface $restRequest,
        RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()->createCustomerUpdater()->updateCustomer($restRequest, $restCustomerAppRequestAttributesTransfer);
    }
}
