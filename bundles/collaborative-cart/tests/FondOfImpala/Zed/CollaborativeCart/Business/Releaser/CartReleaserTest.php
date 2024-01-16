<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Releaser;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriterInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;

class CartReleaserTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteReaderMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $releaseCartRequestTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\Releaser\CartReleaser
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

        $this->quoteWriterMock = $this->getMockBuilder(QuoteWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartRequestTransferMock = $this->getMockBuilder(ReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartReleaser = new CartReleaser(
            $this->quoteReaderMock,
            $this->quoteWriterMock,
        );
    }

    /**
     * @return void
     */
    public function testRelease(): void
    {
        $originalCompanyUserReference = 'FOO--CO-1';
        $originalCustomerReference = 'FOO--1';

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByReleaseCartRequest')
            ->with($this->releaseCartRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getOriginalCompanyUserReference')
            ->willReturn($originalCompanyUserReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn($originalCustomerReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCustomerReference')
            ->with($originalCustomerReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUserReference')
            ->with($originalCompanyUserReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->with(
                static::callback(
                    static function (CustomerTransfer $customerTransfer) use ($originalCustomerReference) {
                        return $customerTransfer->getCustomerReference() === $originalCustomerReference;
                    },
                ),
            )->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setOriginalCustomerReference')
            ->with(null)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setOriginalCompanyUserReference')
            ->with(null)
            ->willReturn($this->quoteTransferMock);

        $this->quoteWriterMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $releaseCartResponseTransfer = $this->cartReleaser->release($this->releaseCartRequestTransferMock);

        static::assertTrue($releaseCartResponseTransfer->getIsSuccess());

        static::assertEquals(
            $this->quoteTransferMock,
            $releaseCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testReleaseWithNonExistingQuote(): void
    {
        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByReleaseCartRequest')
            ->with($this->releaseCartRequestTransferMock)
            ->willReturn(null);

        $this->quoteWriterMock->expects(static::never())
            ->method('update');

        $releaseCartResponseTransfer = $this->cartReleaser->release($this->releaseCartRequestTransferMock);

        static::assertFalse($releaseCartResponseTransfer->getIsSuccess());

        static::assertEquals(
            null,
            $releaseCartResponseTransfer->getQuote(),
        );
    }

    /**
     * @return void
     */
    public function testReleaseWithUpdateError(): void
    {
        $originalCompanyUserReference = 'FOO--CO-1';
        $originalCustomerReference = 'FOO--1';

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByReleaseCartRequest')
            ->with($this->releaseCartRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getOriginalCompanyUserReference')
            ->willReturn($originalCompanyUserReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn($originalCustomerReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCustomerReference')
            ->with($originalCustomerReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUserReference')
            ->with($originalCompanyUserReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->with(
                static::callback(
                    static function (CustomerTransfer $customerTransfer) use ($originalCustomerReference) {
                        return $customerTransfer->getCustomerReference() === $originalCustomerReference;
                    },
                ),
            )->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setOriginalCustomerReference')
            ->with(null)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setOriginalCompanyUserReference')
            ->with(null)
            ->willReturn($this->quoteTransferMock);

        $this->quoteWriterMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->quoteTransferMock)
            ->willReturn(null);

        $releaseCartResponseTransfer = $this->cartReleaser->release($this->releaseCartRequestTransferMock);

        static::assertFalse($releaseCartResponseTransfer->getIsSuccess());

        static::assertEquals(
            null,
            $releaseCartResponseTransfer->getQuote(),
        );
    }
}
