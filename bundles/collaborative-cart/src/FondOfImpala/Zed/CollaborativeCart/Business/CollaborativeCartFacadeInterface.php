<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business;

use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\ClaimCartResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;

interface CollaborativeCartFacadeInterface
{
    /**
     * Specifications:
     * - Expands with original customer transfer (if original_customer_reference is set)
     * - Expands with original company user transfer (if original_company_user_reference is set)
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * Specifications:
     * - Claim cart by ClaimCartRequestTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ClaimCartResponseTransfer
     */
    public function claimCart(ClaimCartRequestTransfer $claimCartRequestTransfer): ClaimCartResponseTransfer;

    /**
     * Specifications:
     * - Release cart by ReleaseCartRequestTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartResponseTransfer
     */
    public function releaseCart(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ReleaseCartResponseTransfer;
}
