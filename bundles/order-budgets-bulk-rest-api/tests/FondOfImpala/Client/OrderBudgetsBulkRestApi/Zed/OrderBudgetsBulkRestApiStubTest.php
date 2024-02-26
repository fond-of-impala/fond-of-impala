<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\Dependency\Client\OrderBudgetsBulkRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetsBulkRestApiStubTest extends Unit
{
    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    protected MockObject|RestOrderBudgetsBulkResponseTransfer $restOrderBudgetsBulkResponseTransferMock;

    protected MockObject|OrderBudgetsBulkRestApiToZedRequestClientInterface $zedRequestClientMock;

    protected OrderBudgetsBulkRestApiStub $orderBudgetsBulkRestApiStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkResponseTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(OrderBudgetsBulkRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetsBulkRestApiStub = new OrderBudgetsBulkRestApiStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testFindOrderBudgetsBulkRestApis(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                OrderBudgetsBulkRestApiStub::BULK_PROCESS,
                $this->restOrderBudgetsBulkRequestTransferMock,
            )->willReturn($this->restOrderBudgetsBulkResponseTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkResponseTransferMock,
            $this->orderBudgetsBulkRestApiStub->bulkProcess($this->restOrderBudgetsBulkRequestTransferMock),
        );
    }
}
