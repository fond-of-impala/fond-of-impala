<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper\OrderBudgetMapperInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface;
use Generated\Shared\Transfer\OrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetPersisterTest extends Unit
{
    protected MockObject|OrderBudgetMapperInterface $orderBudgetMapperMock;

    protected OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface|MockObject $orderBudgetFacadeMock;

    protected RestOrderBudgetsBulkRequestOrderBudgetTransfer|MockObject $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    protected OrderBudgetTransfer|MockObject $orderBudgetTransferMock;

    protected OrderBudgetPersister $orderBudgetPersister;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->orderBudgetMapperMock = $this->getMockBuilder(OrderBudgetMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetFacadeMock = $this->getMockBuilder(OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetTransferMock = $this->getMockBuilder(OrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetPersister = new OrderBudgetPersister(
            $this->orderBudgetMapperMock,
            $this->orderBudgetFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $this->orderBudgetMapperMock->expects(static::atLeastOnce())
            ->method('fromRestOrderBudgetsBulkRequestOrderBudget')
            ->with($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock)
            ->willReturn($this->orderBudgetTransferMock);

        $this->orderBudgetFacadeMock->expects(static::atLeastOnce())
            ->method('updateOrderBudget')
            ->with($this->orderBudgetTransferMock);

        $this->orderBudgetPersister->persist($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);
    }

    /**
     * @return void
     */
    public function testPersistWithInvalidRestOrderBudgetsBulkRequestOrderBudgetTransfer(): void
    {
        $this->orderBudgetMapperMock->expects(static::atLeastOnce())
            ->method('fromRestOrderBudgetsBulkRequestOrderBudget')
            ->with($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock)
            ->willReturn(null);

        $this->orderBudgetFacadeMock->expects(static::never())
            ->method('updateOrderBudget');

        $this->orderBudgetPersister->persist($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);
    }
}
