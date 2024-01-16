<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser;

use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface CartReleaserInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function release(
        RestRequestInterface $restRequest,
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestResponseInterface;
}
