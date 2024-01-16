<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi\Zed;

use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

interface CollaborativeCartsRestApiStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    public function claimCart(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer
    ): RestClaimCartResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartResponseTransfer
     */
    public function releaseCart(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
    ): RestReleaseCartResponseTransfer;
}
