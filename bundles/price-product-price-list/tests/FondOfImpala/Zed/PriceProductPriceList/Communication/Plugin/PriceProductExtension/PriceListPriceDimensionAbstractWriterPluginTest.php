<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade;
use Generated\Shared\Transfer\PriceProductTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListPriceDimensionAbstractWriterPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension\PriceListPriceDimensionAbstractWriterPlugin
     */
    protected PriceListPriceDimensionAbstractWriterPlugin $priceListPriceDimensionAbstractWritePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected MockObject|PriceProductPriceListFacade $priceProductPriceListFacadeMock;

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

        $this->priceProductPriceListFacadeMock = $this->getMockBuilder(PriceProductPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMock = $this->getMockBuilder(PriceProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListPriceDimensionAbstractWritePlugin = new PriceListPriceDimensionAbstractWriterPlugin();
        $this->priceListPriceDimensionAbstractWritePlugin->setFacade($this->priceProductPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testSavePrice(): void
    {
        $this->priceProductPriceListFacadeMock->expects(static::atLeastOnce())->method('savePriceProductPriceList')->willReturn($this->priceProductTransferMock);

        static::assertEquals($this->priceProductTransferMock, $this->priceListPriceDimensionAbstractWritePlugin->savePrice($this->priceProductTransferMock));
    }

    /**
     * @return void
     */
    public function testGetDimensionName(): void
    {
        static::assertSame(PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST, $this->priceListPriceDimensionAbstractWritePlugin->getDimensionName());
    }
}
