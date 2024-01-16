<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\ClaimCartResponseTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;

interface CollaborativeCartsRestApiToCollaborativeCartFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ClaimCartResponseTransfer
     */
    public function claimCart(ClaimCartRequestTransfer $claimCartRequestTransfer): ClaimCartResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartResponseTransfer
     */
    public function releaseCart(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ReleaseCartResponseTransfer;
}
