<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class AllowedProductQuantitySearchToEventBehaviorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToEventBehaviorFacadeBridge
     */
    protected $allowedProductQuantitySearchToEventBehaviorFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacadeInterfaceMock;

    /**
     * @var array
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
