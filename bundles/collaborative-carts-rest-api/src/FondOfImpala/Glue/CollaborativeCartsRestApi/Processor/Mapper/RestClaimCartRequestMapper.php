<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;

class RestClaimCartRequestMapper implements RestClaimCartRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestClaimCartRequestTransfer
     */
    public function fromRestCollaborativeCartsRequestAttributes(
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestClaimCartRequestTransfer {
        return (new RestClaimCartRequestTransfer())
            ->setQuoteUuid($restCollaborativeCartsRequestAttributesTransfer->getCartId());
    }
}
