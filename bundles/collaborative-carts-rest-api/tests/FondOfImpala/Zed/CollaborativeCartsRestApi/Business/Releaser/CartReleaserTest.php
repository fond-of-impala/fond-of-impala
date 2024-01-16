<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapperInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;

class CartReleaserTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteReaderMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $releaseCartRequestMapperMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collaborativeCartFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $releaseCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ReleaseCartResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $releaseCartResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaser
     */
    protected $cartReleaser;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartRequestMapperMock = $this->getMockBuilder(ReleaseCartRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartFacadeMock = $this->getMockBuilder(CollaborativeCartsRestApiToCollaborativeCartFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestTransferMock = $this->getMockBuilder(RestReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartRequestTransferMock = $this->getMockBuilder(ReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartResponseTransferMock = $this->getMockBuilder(ReleaseCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartReleaser = new CartReleaser(
            $this->quoteReaderMock,
            $this->releaseCartRequestMapperMock,
            $this->collaborativeCartFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testRelease(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';
        $id = 1;

        $this->restReleaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn($uuid);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByUuid')
            ->with($uuid)
            ->willReturn($this->quoteTransferMock);

        $this->releaseCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestReleaseCartRequest')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->releaseCartRequestTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($id);

        $this->releaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('setIdQuote')
            ->with($id)
            ->willReturn($this->releaseCartRequestTransferMock);

        $this->collaborativeCartFacadeMock->expects(static::atLeastOnce())
            ->method('releaseCart')
            ->with($this->releaseCartRequestTransferMock)
            ->willReturn($this->releaseCartResponseTransferMock);

        $this->releaseCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->releaseCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $restReleaseCartResponseTransfer = $this->cartReleaser->release($this->restReleaseCartRequestTransferMock);

        static::assertEquals(
            true,
            $restReleaseCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            $this->quoteTransferMock,
            $restReleaseCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testReleaseWithNonExistingQuote(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';

        $this->restReleaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn($uuid);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByUuid')
            ->with($uuid)
            ->willReturn(null);

        $this->releaseCartRequestMapperMock->expects(static::never())
            ->method('fromRestReleaseCartRequest');

        $this->collaborativeCartFacadeMock->expects(static::never())
            ->method('releaseCart');

        $restReleaseCartResponseTransfer = $this->cartReleaser->release($this->restReleaseCartRequestTransferMock);

        static::assertEquals(
            false,
            $restReleaseCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restReleaseCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testReleaseWithoutQuoteUuid(): void
    {
        $this->restReleaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn(null);

        $this->quoteReaderMock->expects(static::never())
            ->method('getByUuid');

        $this->releaseCartRequestMapperMock->expects(static::never())
            ->method('fromRestReleaseCartRequest');

        $this->collaborativeCartFacadeMock->expects(static::never())
            ->method('releaseCart');

        $restReleaseCartResponseTransfer = $this->cartReleaser->release($this->restReleaseCartRequestTransferMock);

        static::assertEquals(
            false,
            $restReleaseCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restReleaseCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testReleaseWithError(): void
    {
        $uuid = '0ed29c58-2b94-492c-9bdd-4bb4135a2cf5';
        $id = 1;

        $this->restReleaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteUuid')
            ->willReturn($uuid);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByUuid')
            ->with($uuid)
            ->willReturn($this->quoteTransferMock);

        $this->releaseCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestReleaseCartRequest')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->releaseCartRequestTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($id);

        $this->releaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('setIdQuote')
            ->with($id)
            ->willReturn($this->releaseCartRequestTransferMock);

        $this->collaborativeCartFacadeMock->expects(static::atLeastOnce())
            ->method('releaseCart')
            ->with($this->releaseCartRequestTransferMock)
            ->willReturn($this->releaseCartResponseTransferMock);

        $this->releaseCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->releaseCartResponseTransferMock->expects(static::never())
            ->method('getIsSuccess');

        $restReleaseCartResponseTransfer = $this->cartReleaser->release($this->restReleaseCartRequestTransferMock);

        static::assertEquals(
            false,
            $restReleaseCartResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restReleaseCartResponseTransfer->getQuote(),
        );
    }
}
