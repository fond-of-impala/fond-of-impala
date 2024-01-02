<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class PriceProductPriceListPageSearchToStoreFacadeBridgeTest extends Unit
{
    protected PriceProductPriceListPageSearchToStoreFacadeBridge $priceProductPriceListPageSearchToStoreFacadeBridge;

    protected MockObject|StoreFacadeInterface $storeFacadeMock;

    protected MockObject|StoreTransfer $storeTransferMock;

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
        $this->storeFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        static::assertEquals(
            $this->storeTransferMock,
            $this->priceProductPriceListPageSearchToStoreFacadeBridge->getCurrentStore(),
        );
    }
}
