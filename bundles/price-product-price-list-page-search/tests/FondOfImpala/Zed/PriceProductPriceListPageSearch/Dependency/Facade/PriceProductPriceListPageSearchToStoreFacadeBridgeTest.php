<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class PriceProductPriceListPageSearchToStoreFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeBridge
     */
    protected $priceProductPriceListPageSearchToStoreFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected $storeTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->storeFacadeMock = $this->getMockBuilder(StoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchToStoreFacadeBridge = new PriceProductPriceListPageSearchToStoreFacadeBridge($this->storeFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetCurrentStore(): void
    {
        $this->storeFacadeMock->expects($this->atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->assertEquals(
            $this->storeTransferMock,
            $this->priceProductPriceListPageSearchToStoreFacadeBridge->getCurrentStore(),
        );
    }
}
