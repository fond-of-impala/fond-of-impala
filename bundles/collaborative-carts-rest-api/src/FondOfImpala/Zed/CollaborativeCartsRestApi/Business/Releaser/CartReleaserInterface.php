<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser;

use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

interface CartReleaserInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartResponseTransfer
     */
    public function release(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
    ): RestReleaseCartResponseTransfer;
}
