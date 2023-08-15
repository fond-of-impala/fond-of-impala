<?php

namespace FondOfImpala\Service\PriceProductPriceList\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductFilterTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Iterator;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\PriceProduct\PriceProductConfig;

class PriceListPriceProductFilterPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\PriceProductPriceList\Plugin\PriceProductExtension\PriceListPriceProductFilterPlugin
     */
    protected PriceListPriceProductFilterPlugin $priceListPriceProductFilterPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductFilterTransfer
     */
    protected MockObject|PriceProductFilterTransfer $priceProductFilterTransferMock;

    /**
     * @var array
     */
    protected array $priceListProductTransfers;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected MockObject|PriceProductDimensionTransfer $priceProductDimensionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Iterator
     */
    protected MockObject|Iterator $iteratorMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

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
        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getPriceDimension')
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceProductDimensionTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        $this->priceProductFilterTransferMock->expects(static::atLeastOnce())
            ->method('getPriceMode')
            ->willReturn(PriceProductConfig::PRICE_GROSS_MODE);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(1);

        static::assertIsArray($this->priceListPriceProductFilterPlugin->filter($this->priceListProductTransfers, $this->priceProductFilterTransferMock));
    }

    /**
     * @return void
     */
    public function testFilterIdPriceListNull(): void
    {
        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getPriceDimension')
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceProductDimensionTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(null);

        $this->priceProductFilterTransferMock->expects(static::atLeastOnce())
            ->method('getPriceMode')
            ->willReturn(PriceProductConfig::PRICE_GROSS_MODE);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(null);

        static::assertIsArray($this->priceListPriceProductFilterPlugin->filter($this->priceListProductTransfers, $this->priceProductFilterTransferMock));
    }

    /**
     * @return void
     */
    public function testGetDimensionName(): void
    {
        static::assertSame(PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST, $this->priceListPriceProductFilterPlugin->getDimensionName());
    }
}
