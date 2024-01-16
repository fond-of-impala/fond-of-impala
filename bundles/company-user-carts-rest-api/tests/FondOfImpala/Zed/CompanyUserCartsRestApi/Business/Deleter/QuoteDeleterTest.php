<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyUserCartsRestApi\CompanyUserCartsRestApiConstants;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteDeleterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteReaderInterface $quoteReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteExpanderInterface|MockObject $quoteExpanderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected WritePermissionCheckerInterface|MockObject $writePermissionCheckerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCartsRestApiToQuoteFacadeInterface|MockObject $quoteFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteResponseTransfer $quoteResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteTransfer $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter\QuoteDeleter
     */
    protected QuoteDeleter $quoteDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpanderMock = $this->getMockBuilder(QuoteExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writePermissionCheckerMock = $this->getMockBuilder(WritePermissionCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteDeleter = new QuoteDeleter(
            $this->quoteReaderMock,
            $this->quoteExpanderMock,
            $this->writePermissionCheckerMock,
            $this->quoteFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteByRestCompanyUserCartsRequest(): void
    {
        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('deleteQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $restCompanyUserCartsResponseTransfer = $this->quoteDeleter->deleteByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertTrue($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertCount(0, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals(null, $restCompanyUserCartsResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testDeleteByRestCompanyUserCartsRequestWithNonExistingQuote(): void
    {
        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(null);

        $this->quoteExpanderMock->expects(static::never())
            ->method('expand');

        $this->quoteFacadeMock->expects(static::never())
            ->method('deleteQuote');

        $restCompanyUserCartsResponseTransfer = $this->quoteDeleter->deleteByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals(
            CompanyUserCartsRestApiConstants::ERROR_MESSAGE_QUOTE_NOT_FOUND,
            $restCompanyUserCartsResponseTransfer->getErrors()->offsetGet(0)->getMessage(),
        );
        static::assertEquals(null, $restCompanyUserCartsResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testDeleteByRestCompanyUserCartsRequestWithError(): void
    {
        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('deleteQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $restCompanyUserCartsResponseTransfer = $this->quoteDeleter->deleteByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals(
            CompanyUserCartsRestApiConstants::ERROR_MESSAGE_QUOTE_NOT_DELETED,
            $restCompanyUserCartsResponseTransfer->getErrors()->offsetGet(0)->getMessage(),
        );
        static::assertEquals(null, $restCompanyUserCartsResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testDeleteByRestCompanyUserCartsRequestWithoutPermission(): void
    {
        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(false);

        $this->quoteReaderMock->expects(static::never())
            ->method('getByRestCompanyUserCartsRequest');

        $this->quoteExpanderMock->expects(static::never())
            ->method('expand');

        $this->quoteFacadeMock->expects(static::never())
            ->method('deleteQuote');

        $restCompanyUserCartsResponseTransfer = $this->quoteDeleter->deleteByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals(
            CompanyUserCartsRestApiConstants::ERROR_MESSAGE_PERMISSION_DENIED,
            $restCompanyUserCartsResponseTransfer->getErrors()->offsetGet(0)->getMessage(),
        );
        static::assertEquals(null, $restCompanyUserCartsResponseTransfer->getQuote());
    }
}
