<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;

class PriceProductPriceListFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected $priceProductPriceListFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListBusinessFactory
     */
    protected $priceProductPriceListBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected $priceProductDimensionTransferMock;

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

        $this->priceProductPriceListBusinessFactoryMock = $this->getMockBuilder(PriceProductPriceListBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductDimensionTransferMock = $this->getMockBuilder(PriceProductDimensionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMock = $this->getMockBuilder(PriceProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListFacade = new PriceProductPriceListFacade();
        $this->priceProductPriceListFacade->setFactory($this->priceProductPriceListBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandPriceProductDimension(): void
    {
        $this->assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceProductPriceListFacade->expandPriceProductDimension($this->priceProductDimensionTransferMock));
    }

    /**
     * @return void
     */
    public function testSavePriceProductPriceList(): void
    {
        $this->assertInstanceOf(PriceProductTransfer::class, $this->priceProductPriceListFacade->savePriceProductPriceList($this->priceProductTransferMock));
    }

    /**
     * @return void
     */
    public function testDeletePriceProductPRiceListByIdPriceProductStore(): void
    {
        $this->priceProductPriceListFacade->deletePriceProductPriceListByIdPriceProductStore(1);
    }
}
