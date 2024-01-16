<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;

class QuoteReader implements QuoteReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface
     */
    protected $quoteFacade;

    /**
     * @param \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface $quoteFacade
     */
    public function __construct(CollaborativeCartToQuoteFacadeInterface $quoteFacade)
    {
        $this->quoteFacade = $quoteFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    public function getByClaimCartRequest(
        ClaimCartRequestTransfer $claimCartRequestTransfer
    ): ?QuoteTransfer {
        $idQuote = $claimCartRequestTransfer->getIdQuote();

        if ($idQuote === null) {
            return null;
        }

        $quoteTransfer = $this->getByIdQuote($idQuote);

        if (
            $quoteTransfer === null
            || $this->isAlreadyClaimed($quoteTransfer)
            || $this->isOwnedByClaimer($claimCartRequestTransfer, $quoteTransfer)
        ) {
            return null;
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    public function getByReleaseCartRequest(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ?QuoteTransfer
    {
        $idQuote = $releaseCartRequestTransfer->getIdQuote();

        if ($idQuote === null) {
            return null;
        }

        $quoteTransfer = $this->getByIdQuote($idQuote);

        if (
            $quoteTransfer === null
            || !$this->isAlreadyClaimed($quoteTransfer)
            || !$this->isOwnedByReleaser($releaseCartRequestTransfer, $quoteTransfer)
        ) {
            return null;
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isAlreadyClaimed(QuoteTransfer $quoteTransfer): bool
    {
        return $quoteTransfer->getOriginalCustomerReference() !== null;
    }

    /**
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isOwnedByClaimer(
        ClaimCartRequestTransfer $claimCartRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): bool {
        return $claimCartRequestTransfer->getNewCustomerReference() === $quoteTransfer->getCustomerReference();
    }

    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isOwnedByReleaser(
        ReleaseCartRequestTransfer $releaseCartRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): bool {
        return $releaseCartRequestTransfer->getCurrentCustomerReference() === $quoteTransfer->getCustomerReference();
    }

    /**
     * @param int $idQuote
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    protected function getByIdQuote(int $idQuote): ?QuoteTransfer
    {
        $quoteResponseTransfer = $this->quoteFacade->findQuoteById($idQuote);
        $quoteTransfer = $quoteResponseTransfer->getQuoteTransfer();

        if ($quoteTransfer === null || !$quoteResponseTransfer->getIsSuccessful()) {
            return null;
        }

        return $quoteTransfer;
    }
}
