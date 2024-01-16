<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\ClaimCartResponseTransfer;

interface CartClaimerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ClaimCartResponseTransfer
     */
    public function claim(ClaimCartRequestTransfer $claimCartRequestTransfer): ClaimCartResponseTransfer;
}
