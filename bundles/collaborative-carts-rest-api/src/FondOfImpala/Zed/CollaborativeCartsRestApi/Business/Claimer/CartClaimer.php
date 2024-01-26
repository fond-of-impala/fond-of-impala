<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer;

use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ClaimCartRequestMapperInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;

class CartClaimer implements CartClaimerInterface
{
    protected QuoteReaderInterface $quoteReader;

    protected ClaimCartRequestMapperInterface $claimCartRequestMapper;

    protected CollaborativeCartsRestApiToCollaborativeCartFacadeInterface $collaborativeCartFacade;

    /**
     * @param \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface $quoteReader
     * @param \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ClaimCartRequestMapperInterface $claimCartRequestMapper
     * @param \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface $collaborativeCartFacade
     */
    public function __construct(
        QuoteReaderInterface $quoteReader,
        ClaimCartRequestMapperInterface $claimCartRequestMapper,
        CollaborativeCartsRestApiToCollaborativeCartFacadeInterface $collaborativeCartFacade
    ) {
        $this->quoteReader = $quoteReader;
        $this->claimCartRequestMapper = $claimCartRequestMapper;
        $this->collaborativeCartFacade = $collaborativeCartFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    public function claim(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer
    ): RestClaimCartResponseTransfer {
        $restClaimCartResponseTransfer = (new RestClaimCartResponseTransfer())->setIsSuccess(false);
        $quoteUuid = $restClaimCartRequestTransfer->getQuoteUuid();

        if ($quoteUuid === null) {
            return $restClaimCartResponseTransfer;
        }

        $quoteTransfer = $this->quoteReader->getByUuid($quoteUuid);

        if ($quoteTransfer === null) {
            return $restClaimCartResponseTransfer;
        }

        $claimCartRequestTransfer = $this->claimCartRequestMapper->fromRestClaimCartRequest(
            $restClaimCartRequestTransfer,
        );

        $claimCartResponseTransfer = $this->collaborativeCartFacade->claimCart(
            $claimCartRequestTransfer->setIdQuote($quoteTransfer->getIdQuote()),
        );

        $quoteTransfer = $claimCartResponseTransfer->getQuote();

        if ($quoteTransfer === null || $claimCartResponseTransfer->getIsSuccess() === false) {
            return $restClaimCartResponseTransfer;
        }

        return $restClaimCartResponseTransfer->setIsSuccess(true)
            ->setQuote($quoteTransfer);
    }
}
