<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;

interface RestReleaseCartRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartRequestTransfer
     */
    public function fromRestCollaborativeCartsRequestAttributes(
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestReleaseCartRequestTransfer;
}
