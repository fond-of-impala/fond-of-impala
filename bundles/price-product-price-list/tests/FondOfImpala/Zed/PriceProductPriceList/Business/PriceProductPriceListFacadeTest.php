<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductPriceListFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected PriceProductPriceListFacade $priceProductPriceListFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListBusinessFactory
     */
    protected MockObject|PriceProductPriceListBusinessFactory $priceProductPriceListBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected MockObject|PriceProductDimensionTransfer $priceProductDimensionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

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
        static::assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceProductPriceListFacade->expandPriceProductDimension($this->priceProductDimensionTransferMock));
    }

    /**
     * @return void
     */
    public function testSavePriceProductPriceList(): void
    {
        static::assertInstanceOf(PriceProductTransfer::class, $this->priceProductPriceListFacade->savePriceProductPriceList($this->priceProductTransferMock));
    }

    /**
     * @return void
     */
    public function testDeletePriceProductPRiceListByIdPriceProductStore(): void
    {
        $this->priceProductPriceListFacade->deletePriceProductPriceListByIdPriceProductStore(1);
    }
}
