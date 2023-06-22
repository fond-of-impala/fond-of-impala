<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge
     */
    protected $conditionalAvailabilityPageSearchToEventBehaviorFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacadeInterfaceMock;

    /**
     * @var array<\Generated\Shared\Transfer\EventEntityTransfer>
     */
    protected $eventTransfers;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\EventEntityTransfer
     */
    protected $eventEntityTransferMock;

    /**
     * @var string
     */
    protected $foreignKeyColumnName;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventBehaviorFacadeInterfaceMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventTransfers = [
            $this->eventEntityTransferMock,
        ];

        $this->foreignKeyColumnName = 'foreign-key-column-name';

        $this->conditionalAvailabilityPageSearchToEventBehaviorFacadeBridge = new ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge(
            $this->eventBehaviorFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetEventTransferIds(): void
    {
        $this->eventBehaviorFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getEventTransferIds')
            ->with($this->eventTransfers)
            ->willReturn([]);

        $this->assertIsArray(
            $this->conditionalAvailabilityPageSearchToEventBehaviorFacadeBridge->getEventTransferIds(
                $this->eventTransfers,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetEventTransferForeignKeys(): void
    {
        $this->eventBehaviorFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getEventTransferForeignKeys')
            ->with($this->eventTransfers, $this->foreignKeyColumnName)
            ->willReturn([]);

        $this->assertIsArray(
            $this->conditionalAvailabilityPageSearchToEventBehaviorFacadeBridge->getEventTransferForeignKeys(
                $this->eventTransfers,
                $this->foreignKeyColumnName,
            ),
        );
    }
}
