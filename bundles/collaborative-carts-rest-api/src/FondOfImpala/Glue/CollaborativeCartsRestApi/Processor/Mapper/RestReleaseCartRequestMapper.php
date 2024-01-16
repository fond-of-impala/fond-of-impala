<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;

class RestReleaseCartRequestMapper implements RestReleaseCartRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartRequestTransfer
     */
    public function fromRestCollaborativeCartsRequestAttributes(
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestReleaseCartRequestTransfer {
        return (new RestReleaseCartRequestTransfer())
            ->setQuoteUuid($restCollaborativeCartsRequestAttributesTransfer->getCartId());
    }
}
