<?php

namespace FondOfImpala\Client\CompanyUsersBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersBulkRestApi\Zed\CompanyUsersBulkRestApiStubInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;

class CompanyUsersBulkRestApiClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfImpala\Client\CompanyUsersBulkRestApi\Zed\CompanyUsersBulkRestApiStubInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $zedStubMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResponseTransferMock;

    /**
     * @var \FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClient
     */
    protected $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyUsersBulkRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(CompanyUsersBulkRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestTransferMock = $this->getMockBuilder(RestCompanyUsersBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseTransferMock = $this->getMockBuilder(RestCompanyUsersBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new CompanyUsersBulkRestApiClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testAddRepresentation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersBulkRestApiStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->restRequestTransferMock)
            ->willReturn($this->restResponseTransferMock);

        static::assertEquals(
            $this->restResponseTransferMock,
            $this->client->bulkProcess($this->restRequestTransferMock),
        );
    }
}
