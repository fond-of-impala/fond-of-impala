<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\Zed\OrderBudgetsBulkRestApiStubInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetsBulkRestApiClientTest extends Unit
{
    protected MockObject|OrderBudgetsBulkRestApiFactory $factoryMock;

    protected MockObject|OrderBudgetsBulkRestApiStubInterface $zedStubMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    protected MockObject|RestOrderBudgetsBulkResponseTransfer $restOrderBudgetsBulkResponseTransferMock;

    protected OrderBudgetsBulkRestApiClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(OrderBudgetsBulkRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(OrderBudgetsBulkRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkResponseTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new OrderBudgetsBulkRestApiClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testFindOrderBudgetsBulkRestApis(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedOrderBudgetsBulkRestApiStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($this->restOrderBudgetsBulkResponseTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkResponseTransferMock,
            $this->client->bulkProcess($this->restOrderBudgetsBulkRequestTransferMock),
        );
    }
}
