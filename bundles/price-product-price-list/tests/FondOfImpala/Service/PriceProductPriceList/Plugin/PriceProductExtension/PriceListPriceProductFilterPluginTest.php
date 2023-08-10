<?php

namespace FondOfImpala\Service\PriceProductPriceList\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductFilterTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Iterator;
use Spryker\Shared\PriceProduct\PriceProductConfig;

class PriceListPriceProductFilterPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\PriceProductPriceList\Plugin\PriceProductExtension\PriceListPriceProductFilterPlugin
     */
    protected $priceListPriceProductFilterPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductFilterTransfer
     */
    protected $priceProductFilterTransferMock;

    /**
     * @var array
     */
    protected $priceListProductTransfers;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected $priceProductDimensionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected $moneyValueTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Iterator
     */
    protected $iteratorMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductTransferMock = $this->getMockBuilder(PriceProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMock = $this->getMockBuilder(PriceProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductFilterTransferMock = $this->getMockBuilder(PriceProductFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductDimensionTransferMock = $this->getMockBuilder(PriceProductDimensionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->moneyValueTransferMock = $this->getMockBuilder(MoneyValueTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder(Iterator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListProductTransfers = [
            $this->priceProductTransferMock,
            $this->priceProductTransferMock,
        ];

        $this->priceListPriceProductFilterPlugin = new PriceListPriceProductFilterPlugin();
    }

    /**
     * @return void
     */
    public function testFilterConditionOne(): void
    {
        $this->priceProductTransferMock->expects($this->atLeastOnce())
            ->method('getPriceDimension')
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceProductDimensionTransferMock->expects($this->atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        $this->priceProductFilterTransferMock->expects($this->atLeastOnce())
            ->method('getPriceMode')
            ->willReturn(PriceProductConfig::PRICE_GROSS_MODE);

        $this->priceProductTransferMock->expects($this->atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects($this->atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(1);

        $this->assertIsArray($this->priceListPriceProductFilterPlugin->filter($this->priceListProductTransfers, $this->priceProductFilterTransferMock));
    }

    /**
     * @return void
     */
    public function testFilterIdPriceListNull(): void
    {
        $this->priceProductTransferMock->expects($this->atLeastOnce())
            ->method('getPriceDimension')
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceProductDimensionTransferMock->expects($this->atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(null);

        $this->priceProductFilterTransferMock->expects($this->atLeastOnce())
            ->method('getPriceMode')
            ->willReturn(PriceProductConfig::PRICE_GROSS_MODE);

        $this->priceProductTransferMock->expects($this->atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects($this->atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(null);

        $this->assertIsArray($this->priceListPriceProductFilterPlugin->filter($this->priceListProductTransfers, $this->priceProductFilterTransferMock));
    }

    /**
     * @return void
     */
    public function testGetDimensionName(): void
    {
        $this->assertSame(PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST, $this->priceListPriceProductFilterPlugin->getDimensionName());
    }
}
