<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\PriceListFacade;
use Generated\Shared\Transfer\PriceListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductPriceListToPriceListFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeBridge
     */
    protected PriceProductPriceListToPriceListFacadeBridge $priceProductPriceListToPriceListFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\PriceListFacade
     */
    protected MockObject|PriceListFacade $priceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected MockObject|PriceListTransfer $priceListTransferMock;

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
        $this->priceListFacadeMock->expects(static::atLeastOnce())
            ->method('findPriceListById')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertInstanceOf(PriceListTransfer::class, $this->priceProductPriceListToPriceListFacadeBridge->findPriceListById($this->priceListTransferMock));
    }
}
