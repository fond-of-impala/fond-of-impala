<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\Event\Listener;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\OrderBudgetsBulkRestApiFacade;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\OrderBudgetsBulkRestApiEvents;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class OrderBudgetPersistProcessListenerTest extends Unit
{
    protected RestOrderBudgetsBulkRequestOrderBudgetTransfer|MockObject $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    protected MockObject|OrderBudgetsBulkRestApiFacade $facadeMock;

    protected OrderBudgetPersistProcessListener $listener;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(OrderBudgetsBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->listener = new OrderBudgetPersistProcessListener();
        $this->listener->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        $eventName = OrderBudgetsBulkRestApiEvents::PERSIST_PROCESS;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('persistOrderBudget')
            ->with($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        $this->listener->handle($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock, $eventName);
    }

    /**
     * @return void
     */
    public function testHandleWithWrongEventName(): void
    {
        $eventName = 'foo';

        $this->facadeMock->expects(static::never())
            ->method('persistOrderBudget');

        $this->listener->handle($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock, $eventName);
    }

    /**
     * @return void
     */
    public function testHandleWithWrongTransferType(): void
    {
        $eventName = OrderBudgetsBulkRestApiEvents::PERSIST_PROCESS;
        $transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock->expects(static::never())
            ->method('persistOrderBudget');

        $this->listener->handle($transferMock, $eventName);
    }
}
