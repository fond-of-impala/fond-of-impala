<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListsBulkRestApi\Dependency\Client\ProductListsBulkRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListsBulkRestApiStubTest extends Unit
{
    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected MockObject|RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransferMock;

    protected MockObject|ProductListsBulkRestApiToZedRequestClientInterface $zedRequestClientMock;

    protected ProductListsBulkRestApiStub $productListsBulkRestApiStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkResponseTransferMock = $this->getMockBuilder(RestProductListsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(ProductListsBulkRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListsBulkRestApiStub = new ProductListsBulkRestApiStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testBulkProcess(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                ProductListsBulkRestApiStub::BULK_PROCESS,
                $this->restProductListsBulkRequestTransferMock,
            )->willReturn($this->restProductListsBulkResponseTransferMock);

        static::assertEquals(
            $this->restProductListsBulkResponseTransferMock,
            $this->productListsBulkRestApiStub->bulkProcess($this->restProductListsBulkRequestTransferMock),
        );
    }
}
