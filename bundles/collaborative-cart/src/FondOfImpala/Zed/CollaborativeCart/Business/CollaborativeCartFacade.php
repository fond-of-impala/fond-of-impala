<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business;

use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\ClaimCartResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface getRepository()
 */
class CollaborativeCartFacade extends AbstractFacade implements CollaborativeCartFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()->createQuoteExpander()->expand($quoteTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ClaimCartResponseTransfer
     */
    public function claimCart(ClaimCartRequestTransfer $claimCartRequestTransfer): ClaimCartResponseTransfer
    {
        return $this->getFactory()->createCartClaimer()->claim($claimCartRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartResponseTransfer
     */
    public function releaseCart(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ReleaseCartResponseTransfer
    {
        return $this->getFactory()->createCartReleaser()->release($releaseCartRequestTransfer);
    }
}
