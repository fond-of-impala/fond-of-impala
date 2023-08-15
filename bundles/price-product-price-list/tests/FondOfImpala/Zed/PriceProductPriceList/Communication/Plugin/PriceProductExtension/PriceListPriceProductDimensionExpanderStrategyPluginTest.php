<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListPriceProductDimensionExpanderStrategyPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension\PriceListPriceProductDimensionExpanderStrategyPlugin
     */
    protected PriceListPriceProductDimensionExpanderStrategyPlugin $priceListPriceProductDimensionExpanderStrategyPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected MockObject|PriceProductPriceListFacade $priceProductPriceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected MockObject|PriceProductDimensionTransfer $priceProductDimensionTransferMock;

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
        static::assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceListPriceProductDimensionExpanderStrategyPlugin->expand($this->priceProductDimensionTransferMock));
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->priceProductDimensionTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        static::assertTrue($this->priceListPriceProductDimensionExpanderStrategyPlugin->isApplicable($this->priceProductDimensionTransferMock));
    }
}
