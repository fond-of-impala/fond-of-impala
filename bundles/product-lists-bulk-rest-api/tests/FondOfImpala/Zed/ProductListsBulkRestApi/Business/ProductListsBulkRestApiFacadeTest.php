<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor\BulkProcessorInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListsBulkRestApiFacadeTest extends Unit
{
    protected MockObject|BulkProcessorInterface $bulkProcessorMock;

    protected ProductListsBulkRestApiFacadeInterface $facade;

    protected MockObject|ProductListsBulkRestApiBusinessFactory $factoryMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected MockObject|RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransferMock;

    protected MockObject|RestProductListsBulkRequestExpanderInterface $restProductListsBulkRequestExpanderMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->bulkProcessorMock = $this->getMockBuilder(BulkProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ProductListsBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkResponseTransferMock = $this->getMockBuilder(RestProductListsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestExpanderMock = $this->getMockBuilder(RestProductListsBulkRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ProductListsBulkRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandRestProductListsBulkRequest(): void
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createRestProductListsBulkRequestExpander')
            ->willReturn($this->restProductListsBulkRequestExpanderMock);

        $this->restProductListsBulkRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $this->facade->expandRestProductListsBulkRequest($this->restProductListsBulkRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBulkProcess(): void
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createBulkProcessor')
            ->willReturn($this->bulkProcessorMock);

        $this->bulkProcessorMock->expects(static::atLeastOnce())
            ->method('process')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkResponseTransferMock);

        static::assertEquals(
            $this->restProductListsBulkResponseTransferMock,
            $this->facade->bulkProcess($this->restProductListsBulkRequestTransferMock),
        );
    }
}
