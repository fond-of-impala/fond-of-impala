<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;

class PriceListPriceProductDimensionExpanderStrategyPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension\PriceListPriceProductDimensionExpanderStrategyPlugin
     */
    protected $priceListPriceProductDimensionExpanderStrategyPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected $priceProductPriceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected $priceProductDimensionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListFacadeMock = $this->getMockBuilder(PriceProductPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductDimensionTransferMock = $this->getMockBuilder(PriceProductDimensionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListPriceProductDimensionExpanderStrategyPlugin = new PriceListPriceProductDimensionExpanderStrategyPlugin();
        $this->priceListPriceProductDimensionExpanderStrategyPlugin->setFacade($this->priceProductPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceListPriceProductDimensionExpanderStrategyPlugin->expand($this->priceProductDimensionTransferMock));
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->priceProductDimensionTransferMock->expects($this->atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        $this->assertTrue($this->priceListPriceProductDimensionExpanderStrategyPlugin->isApplicable($this->priceProductDimensionTransferMock));
    }
}
