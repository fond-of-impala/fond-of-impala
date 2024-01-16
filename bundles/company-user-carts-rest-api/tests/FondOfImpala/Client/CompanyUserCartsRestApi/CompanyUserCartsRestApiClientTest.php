<?php

namespace FondOfImpala\Client\CompanyUserCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserCartsRestApi\Zed\CompanyUserCartsRestApiStubInterface;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;

class CompanyUserCartsRestApiClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiFactory|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $factoryMock;

    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\Zed\CompanyUserCartsRestApiStubInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $zedStubMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsResponseTransferMock;

    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClient
     */
    protected $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyUserCartsRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(CompanyUserCartsRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsResponseTransferMock = $this->getMockBuilder(RestCompanyUserCartsResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new CompanyUserCartsRestApiClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserCartsRestApiStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('createQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->client->createQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserCartsRestApiStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('updateQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->client->updateQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserCartsRestApiStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('deleteQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->client->deleteQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindQuoteByRestCompanyUserCartsRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserCartsRestApiStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('findQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->client->findQuoteByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }
}
