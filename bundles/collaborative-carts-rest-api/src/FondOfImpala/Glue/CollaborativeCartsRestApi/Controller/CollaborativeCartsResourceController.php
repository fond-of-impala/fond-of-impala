<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Controller;

use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface getClient()
 * @method \FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory getFactory()
 */
class CollaborativeCartsResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createCollaborativeCartProcessor()
            ->process($restRequest, $restCollaborativeCartsRequestAttributesTransfer);
    }
}
