<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyUserCartsRestApi\CompanyUserCartsRestApiConstants;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteFinderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteReaderInterface $quoteReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionCheckerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ReadPermissionCheckerInterface $readPermissionCheckerMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteTransfer $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinder
     */
    protected QuoteFinder $quoteFinder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->readPermissionCheckerMock = $this->getMockBuilder(ReadPermissionCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFinder = new QuoteFinder(
            $this->quoteReaderMock,
            $this->readPermissionCheckerMock,
        );
    }

    /**
     * @return void
     */
    public function testFindOneByRestCompanyUserCartsRequest(): void
    {
        $this->readPermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $restCompanyUserCartsResponseTransfer = $this->quoteFinder->findOneByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertTrue($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertEquals($this->quoteTransferMock, $restCompanyUserCartsResponseTransfer->getQuote());
        static::assertCount(0, $restCompanyUserCartsResponseTransfer->getErrors());
    }

    /**
     * @return void
     */
    public function testFindOneByRestCompanyUserCartsRequestWithError(): void
    {
        $this->readPermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(null);

        $restCompanyUserCartsResponseTransfer = $this->quoteFinder->findOneByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertEquals(null, $restCompanyUserCartsResponseTransfer->getQuote());
        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals(
            CompanyUserCartsRestApiConstants::ERROR_MESSAGE_QUOTE_NOT_FOUND,
            $restCompanyUserCartsResponseTransfer->getErrors()->offsetGet(0)->getMessage(),
        );
    }

    /**
     * @return void
     */
    public function testFindOneByRestCompanyUserCartsRequestWithoutPermission(): void
    {
        $this->readPermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(false);

        $this->quoteReaderMock->expects(static::never())
            ->method('getByRestCompanyUserCartsRequest');

        $restCompanyUserCartsResponseTransfer = $this->quoteFinder->findOneByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertEquals(null, $restCompanyUserCartsResponseTransfer->getQuote());
        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals(
            CompanyUserCartsRestApiConstants::ERROR_MESSAGE_PERMISSION_DENIED,
            $restCompanyUserCartsResponseTransfer->getErrors()->offsetGet(0)->getMessage(),
        );
    }
}
