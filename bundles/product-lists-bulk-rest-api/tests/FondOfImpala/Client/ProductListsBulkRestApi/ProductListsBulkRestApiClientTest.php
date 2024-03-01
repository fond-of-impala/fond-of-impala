<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListsBulkRestApi\Zed\ProductListsBulkRestApiStubInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListsBulkRestApiClientTest extends Unit
{
    protected MockObject|ProductListsBulkRestApiFactory $factoryMock;

    protected MockObject|ProductListsBulkRestApiStubInterface $zedStubMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected MockObject|RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransferMock;

    protected ProductListsBulkRestApiClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(ProductListsBulkRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(ProductListsBulkRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkResponseTransferMock = $this->getMockBuilder(RestProductListsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new ProductListsBulkRestApiClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testBulkProcess(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedProductListsBulkRestApiStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkResponseTransferMock);

        static::assertEquals(
            $this->restProductListsBulkResponseTransferMock,
            $this->client->bulkProcess($this->restProductListsBulkRequestTransferMock),
        );
    }
}
