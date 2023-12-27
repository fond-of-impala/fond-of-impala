<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchValueTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceGrouperTest extends Unit
{
    protected PriceGrouper $priceGrouper;

    protected MockObject|PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransferMock;

    protected MockObject|PriceProductPriceListPageSearchValueTransfer $priceProductPriceListPageSearchValueTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListPageSearchTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchValueTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchValueTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceGrouper = new PriceGrouper();
    }

    /**
     * @return void
     */
    public function testGroupPricesData(): void
    {
        $this->priceProductPriceListPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getUngroupedPrices')
            ->willReturn([$this->priceProductPriceListPageSearchValueTransferMock]);

        $this->priceProductPriceListPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setPrices')
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $this->priceProductPriceListPageSearchValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossPrice')
            ->willReturn(1);

        static::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->priceGrouper->groupPricesData(
                $this->priceProductPriceListPageSearchTransferMock,
                ['prices' => []],
            ),
        );
    }
}
