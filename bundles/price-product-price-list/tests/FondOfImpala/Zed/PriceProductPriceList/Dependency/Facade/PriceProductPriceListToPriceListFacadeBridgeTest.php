<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\PriceListFacade;
use Generated\Shared\Transfer\PriceListTransfer;

class PriceProductPriceListToPriceListFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeBridge
     */
    protected $priceProductPriceListToPriceListFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\PriceListFacade
     */
    protected $priceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected $priceListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceListFacadeMock = $this->getMockBuilder(PriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListToPriceListFacadeBridge = new PriceProductPriceListToPriceListFacadeBridge(
            $this->priceListFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindPriceListById(): void
    {
        $this->priceListFacadeMock->expects($this->atLeastOnce())
            ->method('findPriceListById')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        $this->assertInstanceOf(PriceListTransfer::class, $this->priceProductPriceListToPriceListFacadeBridge->findPriceListById($this->priceListTransferMock));
    }
}
