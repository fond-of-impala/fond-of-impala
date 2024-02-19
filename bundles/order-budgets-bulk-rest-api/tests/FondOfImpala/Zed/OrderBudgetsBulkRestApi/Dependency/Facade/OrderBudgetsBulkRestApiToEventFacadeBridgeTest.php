<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class OrderBudgetsBulkRestApiToEventFacadeBridgeTest extends Unit
{
    protected EventFacadeInterface|MockObject $facadeMock;

    protected TransferInterface|MockObject $transferMock;

    protected OrderBudgetsBulkRestApiToEventFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(EventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new OrderBudgetsBulkRestApiToEventFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testTrigger(): void
    {
        $eventName = 'foo';

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with($eventName, $this->transferMock);

        $this->bridge->trigger($eventName, $this->transferMock);
    }
}
