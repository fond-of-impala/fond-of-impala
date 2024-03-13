<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge $bridge;

    protected MockObject|EventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @var array<\Generated\Shared\Transfer\EventEntityTransfer>
     */
    protected array $eventTransfers;

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

        $this->bridge = new ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge(
            $this->eventBehaviorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetEventTransferForeignKeys(): void
    {
        $eventTransfers = [
            $this->eventEntityTransferMock,
        ];

        $foreignKeyColumnName = 'foreign-key-column-name';

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('getEventTransferForeignKeys')
            ->with($eventTransfers, $foreignKeyColumnName)
            ->willReturn([]);

        static::assertEquals(
            [],
            $this->bridge->getEventTransferForeignKeys(
                $eventTransfers,
                $foreignKeyColumnName,
            ),
        );
    }
}
