<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfOryx\Zed\OrderBudget\Business\OrderBudgetFacadeInterface;
use Generated\Shared\Transfer\OrderBudgetTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetsBulkRestApiToOrderBudgetFacadeBridgeTest extends Unit
{
    protected MockObject|OrderBudgetFacadeInterface $facadeMock;

    protected OrderBudgetTransfer|MockObject $orderBudgetTransferMock;

    protected OrderBudgetsBulkRestApiToOrderBudgetFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(OrderBudgetFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetTransferMock = $this->getMockBuilder(OrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new OrderBudgetsBulkRestApiToOrderBudgetFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testUpdateOrderBudget(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('updateOrderBudget')
            ->with($this->orderBudgetTransferMock);

        $this->bridge->updateOrderBudget($this->orderBudgetTransferMock);
    }
}
