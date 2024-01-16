<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi;

use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

interface CollaborativeCartsRestApiClientInterface
{
    /**
     * Specification:
     * - Claims cart
     * - Makes zed request.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    public function claimCart(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer
    ): RestClaimCartResponseTransfer;

    /**
     * Specification:
     * - Releases cart
     * - Makes zed request.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartResponseTransfer
     */
    public function releaseCart(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
    ): RestReleaseCartResponseTransfer;
}
