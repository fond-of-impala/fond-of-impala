<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\PriceProduct\Business\PriceProductFacade;

class PriceProductPriceListToPriceProductFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeBridge
     */
    protected $priceProductPriceListToPriceProductFacadeBridgeTest;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\PriceProduct\Business\PriceProductFacade
     */
    protected $priceProductFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected $priceProductTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductFacadeMock = $this->getMockBuilder(PriceProductFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMock = $this->getMockBuilder(PriceProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListToPriceProductFacadeBridgeTest = new PriceProductPriceListToPriceProductFacadeBridge(
            $this->priceProductFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPersistPriceProductStore(): void
    {
        $this->assertInstanceOf(PriceProductTransfer::class, $this->priceProductPriceListToPriceProductFacadeBridgeTest->persistPriceProductStore($this->priceProductTransferMock));
    }
}
