<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge
     */
    protected $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected MockObject|EventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\EventEntityTransfer
     */
    protected MockObject|EventEntityTransfer $eventEntityTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventBehaviorFacadeMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->bridge = new ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge($this->eventBehaviorFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetEventTransferIds(): void
    {
        $eventTransfers = [$this->eventEntityTransferMock];

        $this->eventBehaviorFacadeMock->expects($this->atLeastOnce())
            ->method('getEventTransferIds')
            ->with($eventTransfers)
            ->willReturn([]);

        static::assertIsArray(
            $this->bridge->getEventTransferIds($eventTransfers),
        );
    }

    /**
     * @return void
     */
    public function testGetEventTransferForeignKeys(): void
    {
        $eventTransfers = [$this->eventEntityTransferMock];
        $foreignKeyColumnName = 'foreign-key-column-name';

        $this->eventBehaviorFacadeMock->expects($this->atLeastOnce())
            ->method('getEventTransferForeignKeys')
            ->with($eventTransfers, $foreignKeyColumnName)
            ->willReturn([]);

        static::assertIsArray(
            $this->bridge->getEventTransferForeignKeys($eventTransfers, $foreignKeyColumnName),
        );
    }
}
