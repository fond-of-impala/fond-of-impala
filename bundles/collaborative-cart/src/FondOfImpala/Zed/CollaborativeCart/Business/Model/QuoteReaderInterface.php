<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;

interface QuoteReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    public function getByClaimCartRequest(ClaimCartRequestTransfer $claimCartRequestTransfer): ?QuoteTransfer;

    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    public function getByReleaseCartRequest(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ?QuoteTransfer;
}
