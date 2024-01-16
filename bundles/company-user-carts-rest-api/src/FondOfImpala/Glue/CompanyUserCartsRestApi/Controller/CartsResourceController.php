<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Controller;

use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiFactory getFactory()
 */
class CartsResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        return $this->getFactory()->createCartFinder()->find($restRequest);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(RestRequestInterface $restRequest, RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer): RestResponseInterface
    {
        return $this->getFactory()->createCartCreator()->create($restRequest, $restCartsRequestAttributesTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patchAction(
        RestRequestInterface $restRequest,
        RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()->createCartUpdater()->update($restRequest, $restCartsRequestAttributesTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function deleteAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        return $this->getFactory()->createCartDeleter()->delete($restRequest);
    }
}
