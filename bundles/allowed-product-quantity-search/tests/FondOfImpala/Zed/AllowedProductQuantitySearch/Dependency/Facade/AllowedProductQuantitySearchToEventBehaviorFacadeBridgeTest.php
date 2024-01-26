<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class AllowedProductQuantitySearchToEventBehaviorFacadeBridgeTest extends Unit
{
    protected AllowedProductQuantitySearchToEventBehaviorFacadeBridge $allowedProductQuantitySearchToEventBehaviorFacadeBridge;

    protected MockObject|EventBehaviorFacadeInterface $eventBehaviorFacadeInterfaceMock;

    /**
     * @var array
     */
    protected $eventTransfers;

    protected MockObject|EventEntityTransfer $eventEntityTransferMock;

    protected string $foreignKeyColumnName;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventBehaviorFacadeInterfaceMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventTransfers = [
            $this->eventBehaviorFacadeInterfaceMock,
        ];

        $this->foreignKeyColumnName = 'foreign-key-column-name';

        $this->allowedProductQuantitySearchToEventBehaviorFacadeBridge = new AllowedProductQuantitySearchToEventBehaviorFacadeBridge(
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
            ->willReturn($this->eventTransfers);

        $this->assertIsArray($this->allowedProductQuantitySearchToEventBehaviorFacadeBridge->getEventTransferIds($this->eventTransfers));
    }

    /**
     * @return void
     */
    public function testGetEventTransferForeignKeys(): void
    {
        $this->eventBehaviorFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getEventTransferForeignKeys')
            ->willReturn($this->eventTransfers);

        $this->assertIsArray($this->allowedProductQuantitySearchToEventBehaviorFacadeBridge->getEventTransferForeignKeys($this->eventTransfers, $this->foreignKeyColumnName));
    }
}
