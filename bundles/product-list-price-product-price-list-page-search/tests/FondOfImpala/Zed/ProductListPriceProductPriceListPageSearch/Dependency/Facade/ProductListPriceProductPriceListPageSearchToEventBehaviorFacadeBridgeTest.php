<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $facadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\Generated\Shared\Transfer\EventEntityTransfer[]
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
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventTransfers = [
            $this->eventEntityTransferMock,
        ];

        $this->foreignKeyColumnName = 'foreign-key-column-name';

        $this->bridge = new ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetEventTransferForeignKeys(): void
    {
        $this->facadeMock->expects(self::atLeastOnce())
            ->method('getEventTransferForeignKeys')
            ->with($this->eventTransfers, $this->foreignKeyColumnName)
            ->willReturn([]);

        self::assertIsArray(
            $this->bridge->getEventTransferForeignKeys(
                $this->eventTransfers,
                $this->foreignKeyColumnName,
            ),
        );
    }
}
