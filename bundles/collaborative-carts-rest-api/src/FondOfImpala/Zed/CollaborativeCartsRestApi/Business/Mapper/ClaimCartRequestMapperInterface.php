<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper;

use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;

interface ClaimCartRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ClaimCartRequestTransfer
     */
    public function fromRestClaimCartRequest(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer
    ): ClaimCartRequestTransfer;
}
