<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ClaimCartRequestMapperInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\ClaimCartResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;

class CartClaimerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteReaderMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ClaimCartRequestMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $claimCartRequestMapperMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collaborativeCartFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestClaimCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restClaimCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ClaimCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $claimCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ClaimCartResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $claimCartResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimer
     */
    protected $cartClaimer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartRequestMapperMock = $this->getMockBuilder(ClaimCartRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartFacadeMock = $this->getMockBuilder(CollaborativeCartsRestApiToCollaborativeCartFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestTransferMock = $this->getMockBuilder(RestClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartRequestTransferMock = $this->getMockBuilder(ClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartResponseTransferMock = $this->getMockBuilder(ClaimCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartClaimer = new CartClaimer(
            $this->quoteReaderMock,
            $this->claimCartRequestMapperMock,
            $this->collaborativeCartFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testClaim(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';
        $id = 1;

        $this->restClaimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn($uuid);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByUuid')
            ->with($uuid)
            ->willReturn($this->quoteTransferMock);

        $this->claimCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestClaimCartRequest')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->claimCartRequestTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($id);

        $this->claimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('setIdQuote')
            ->with($id)
            ->willReturn($this->claimCartRequestTransferMock);

        $this->collaborativeCartFacadeMock->expects(static::atLeastOnce())
            ->method('claimCart')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->claimCartResponseTransferMock);

        $this->claimCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->claimCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $restClaimCartResponseTransfer = $this->cartClaimer->claim($this->restClaimCartRequestTransferMock);

        static::assertEquals(
            true,
            $restClaimCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            $this->quoteTransferMock,
            $restClaimCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testClaimWithNonExistingQuote(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';

        $this->restClaimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn($uuid);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByUuid')
            ->with($uuid)
            ->willReturn(null);

        $this->claimCartRequestMapperMock->expects(static::never())
            ->method('fromRestClaimCartRequest');

        $this->collaborativeCartFacadeMock->expects(static::never())
            ->method('claimCart');

        $restClaimCartResponseTransfer = $this->cartClaimer->claim($this->restClaimCartRequestTransferMock);

        static::assertEquals(
            false,
            $restClaimCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restClaimCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testClaimWithoutQuoteUuid(): void
    {
        $this->restClaimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn(null);

        $this->quoteReaderMock->expects(static::never())
            ->method('getByUuid');

        $this->claimCartRequestMapperMock->expects(static::never())
            ->method('fromRestClaimCartRequest');

        $this->collaborativeCartFacadeMock->expects(static::never())
            ->method('claimCart');

        $restClaimCartResponseTransfer = $this->cartClaimer->claim($this->restClaimCartRequestTransferMock);

        static::assertEquals(
            false,
            $restClaimCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restClaimCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testClaimWithError(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';
        $id = 1;

        $this->restClaimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn($uuid);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByUuid')
            ->with($uuid)
            ->willReturn($this->quoteTransferMock);

        $this->claimCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestClaimCartRequest')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->claimCartRequestTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($id);

        $this->claimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('setIdQuote')
            ->with($id)
            ->willReturn($this->claimCartRequestTransferMock);

        $this->collaborativeCartFacadeMock->expects(static::atLeastOnce())
            ->method('claimCart')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->claimCartResponseTransferMock);

        $this->claimCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->claimCartResponseTransferMock->expects(static::never())
            ->method('getIsSuccess');

        $restClaimCartResponseTransfer = $this->cartClaimer->claim($this->restClaimCartRequestTransferMock);

        static::assertEquals(
            false,
            $restClaimCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restClaimCartResponseTransfer->getQuote(),
        );
    }
}
