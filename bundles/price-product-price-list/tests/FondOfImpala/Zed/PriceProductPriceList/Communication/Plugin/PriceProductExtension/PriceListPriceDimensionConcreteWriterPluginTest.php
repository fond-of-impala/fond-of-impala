<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade;
use Generated\Shared\Transfer\PriceProductTransfer;

class PriceListPriceDimensionConcreteWriterPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension\PriceListPriceDimensionConcreteWriterPlugin
     */
    protected $priceListPriceDimensionConcreteWriterPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected $priceProductPriceListFacadeMock;

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

        $this->priceProductPriceListFacadeMock = $this->getMockBuilder(PriceProductPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMock = $this->getMockBuilder(PriceProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListPriceDimensionConcreteWriterPlugin = new PriceListPriceDimensionConcreteWriterPlugin();
        $this->priceListPriceDimensionConcreteWriterPlugin->setFacade($this->priceProductPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testSavePrice(): void
    {
        $this->assertInstanceOf(PriceProductTransfer::class, $this->priceListPriceDimensionConcreteWriterPlugin->savePrice($this->priceProductTransferMock));
    }

    /**
     * @return void
     */
    public function testGetDimensionName(): void
    {
        $this->assertSame(PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST, $this->priceListPriceDimensionConcreteWriterPlugin->getDimensionName());
    }
}
