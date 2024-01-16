<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator\QuoteCreatorInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter\QuoteDeleterInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater\QuoteUpdaterInterface;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;

class CompanyUserCartsRestApiFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\CompanyUserCartsRestApiBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator\QuoteCreatorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteCreatorMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater\QuoteUpdaterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteUpdaterMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter\QuoteDeleterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteDeleterMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteFinderMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\CompanyUserCartsRestApiFacade
     */
    protected $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyUserCartsRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCreatorMock = $this->getMockBuilder(QuoteCreatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteUpdaterMock = $this->getMockBuilder(QuoteUpdaterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteDeleterMock = $this->getMockBuilder(QuoteDeleterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFinderMock = $this->getMockBuilder(QuoteFinderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsResponseTransferMock = $this->getMockBuilder(RestCompanyUserCartsResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyUserCartsRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteCreator')
            ->willReturn($this->quoteCreatorMock);

        $this->quoteCreatorMock->expects(static::atLeastOnce())
            ->method('createByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->facade->createQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteUpdater')
            ->willReturn($this->quoteUpdaterMock);

        $this->quoteUpdaterMock->expects(static::atLeastOnce())
            ->method('updateByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->facade->updateQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteDeleter')
            ->willReturn($this->quoteDeleterMock);

        $this->quoteDeleterMock->expects(static::atLeastOnce())
            ->method('deleteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->facade->deleteQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteFinder')
            ->willReturn($this->quoteFinderMock);

        $this->quoteFinderMock->expects(static::atLeastOnce())
            ->method('findOneByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->facade->findQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }
}
