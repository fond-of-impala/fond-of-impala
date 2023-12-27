<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected MockObject|EventBehaviorFacadeInterface $facadeMock;

    /**
     * @var array<\Generated\Shared\Transfer\EventEntityTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $eventTransfers;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\EventEntityTransfer
     */
    protected MockObject|EventEntityTransfer $eventEntityTransferMock;

    /**
     * @var string
     */
    protected string $foreignKeyColumnName;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge
     */
    protected ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge $bridge;

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
