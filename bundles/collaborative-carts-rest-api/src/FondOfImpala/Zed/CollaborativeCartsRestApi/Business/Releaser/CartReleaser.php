<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser;

use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapperInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

class CartReleaser implements CartReleaserInterface
{
    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface
     */
    protected $quoteReader;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapperInterface
     */
    protected $releaseCartRequestMapper;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface
     */
    protected $collaborativeCartFacade;

    /**
     * @param \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface $quoteReader
     * @param \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapperInterface $releaseCartRequestMapper
     * @param \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface $collaborativeCartFacade
     */
    public function __construct(
        QuoteReaderInterface $quoteReader,
        ReleaseCartRequestMapperInterface $releaseCartRequestMapper,
        CollaborativeCartsRestApiToCollaborativeCartFacadeInterface $collaborativeCartFacade
    ) {
        $this->quoteReader = $quoteReader;
        $this->releaseCartRequestMapper = $releaseCartRequestMapper;
        $this->collaborativeCartFacade = $collaborativeCartFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartResponseTransfer
     */
    public function release(RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer): RestReleaseCartResponseTransfer
    {
        $restReleaseCartResponseTransfer = (new RestReleaseCartResponseTransfer())->setIsSuccess(false);
        $quoteUuid = $restReleaseCartRequestTransfer->getQuoteUuid();

        if ($quoteUuid === null) {
            return $restReleaseCartResponseTransfer;
        }

        $quoteTransfer = $this->quoteReader->getByUuid($quoteUuid);

        if ($quoteTransfer === null) {
            return $restReleaseCartResponseTransfer;
        }

        $releaseCartRequestTransfer = $this->releaseCartRequestMapper->fromRestReleaseCartRequest(
            $restReleaseCartRequestTransfer,
        );

        $releaseCartResponseTransfer = $this->collaborativeCartFacade->releaseCart(
            $releaseCartRequestTransfer->setIdQuote($quoteTransfer->getIdQuote()),
        );

        $quoteTransfer = $releaseCartResponseTransfer->getQuote();

        if ($quoteTransfer === null || $releaseCartResponseTransfer->getIsSuccess() === false) {
            return $restReleaseCartResponseTransfer;
        }

        return $restReleaseCartResponseTransfer->setIsSuccess(true)
            ->setQuote($quoteTransfer);
    }
}
