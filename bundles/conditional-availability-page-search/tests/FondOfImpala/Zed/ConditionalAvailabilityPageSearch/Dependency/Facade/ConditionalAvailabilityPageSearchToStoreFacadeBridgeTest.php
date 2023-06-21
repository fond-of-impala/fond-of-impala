<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class ConditionalAvailabilityPageSearchToStoreFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeBridge
     */
    protected $conditionalAvailabilityPageSearchToStoreFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected $storeTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->storeFacadeInterfaceMock = $this->getMockBuilder(StoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToStoreFacadeBridge = new ConditionalAvailabilityPageSearchToStoreFacadeBridge(
            $this->storeFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCurrentStore(): void
    {
        $this->storeFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->assertEquals(
            $this->storeTransferMock,
            $this->conditionalAvailabilityPageSearchToStoreFacadeBridge->getCurrentStore(),
        );
    }
}
