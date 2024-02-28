<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class ProductListsBulkRestApiToEventFacadeBridgeTest extends Unit
{
    protected ProductListsBulkRestApiToEventFacadeBridge $bridge;

    protected MockObject|ProductListsBulkRestApiToEventFacadeBridge $eventFacadeMock;

    protected MockObject|TransferInterface $transferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventFacadeMock = $this->getMockBuilder(EventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ProductListsBulkRestApiToEventFacadeBridge($this->eventFacadeMock);
    }

    /**
     * @return void
     */
    public function testTrigger(): void
    {
        $eventName = 'event-name';
        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with($eventName, $this->transferMock);

        $this->bridge->trigger($eventName, $this->transferMock);
    }
}
