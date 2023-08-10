<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class PriceProductPriceListPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToEventBehaviorFacadeBridge
     */
    protected $priceProductPriceListPageSearchToEventBehaviorFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\EventEntityTransfer
     */
    protected $eventEntityTransferMock;

    /**
     * @var array
     */
    protected $eventTransfers;

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

        $this->priceProductPriceListPageSearchToEventBehaviorFacadeBridge = new PriceProductPriceListPageSearchToEventBehaviorFacadeBridge($this->eventBehaviorFacadeInterfaceMock);
    }

    /**
     * @return void
     */
    public function testGetEventTransferIds(): void
    {
        $this->eventBehaviorFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getEventTransferIds')
            ->willReturn($this->eventTransfers);

        $this->assertIsArray($this->priceProductPriceListPageSearchToEventBehaviorFacadeBridge->getEventTransferIds($this->eventTransfers));
    }

    /**
     * @return void
     */
    public function testGetEventTransferForeignKeys(): void
    {
        $this->eventBehaviorFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getEventTransferForeignKeys')
            ->willReturn($this->eventTransfers);

        $this->assertIsArray($this->priceProductPriceListPageSearchToEventBehaviorFacadeBridge->getEventTransferForeignKeys($this->eventTransfers, 'fk_key'));
    }
}
