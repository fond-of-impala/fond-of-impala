<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Releaser;

use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;

interface CartReleaserInterface
{
    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartResponseTransfer
     */
    public function release(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ReleaseCartResponseTransfer;
}
