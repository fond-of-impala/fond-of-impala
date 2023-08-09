<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchValueTransfer;

class PriceGrouperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceGrouper
     */
    protected $priceGrouper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected $priceProductPriceListPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchValueTransfer
     */
    protected $priceProductPriceListPageSearchValueTransferMock;

    /**
     * @var array
     */
    protected $priceTransfers;

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

        $this->priceTransfers = [
            $this->priceProductPriceListPageSearchValueTransferMock,
        ];

        $this->priceGrouper = new PriceGrouper();
    }

    /**
     * @return void
     */
    public function testGroupPricesData(): void
    {
        $this->priceProductPriceListPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getUngroupedPrices')
            ->willReturn($this->priceTransfers);

        $this->priceProductPriceListPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('setPrices')
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $this->priceProductPriceListPageSearchValueTransferMock->expects($this->atLeastOnce())
            ->method('getGrossPrice')
            ->willReturn(1);

        $this->assertInstanceOf(PriceProductPriceListPageSearchTransfer::class, $this->priceGrouper->groupPricesData($this->priceProductPriceListPageSearchTransferMock, ['prices' => []]));
    }
}
