<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchValueTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceGrouperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceGrouper
     */
    protected PriceGrouper $priceGrouper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected MockObject|PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchValueTransfer
     */
    protected MockObject|PriceProductPriceListPageSearchValueTransfer $priceProductPriceListPageSearchValueTransferMock;

    /**
     * @var array
     */
    protected array $priceTransfers;

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
        $this->priceProductPriceListPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getUngroupedPrices')
            ->willReturn($this->priceTransfers);

        $this->priceProductPriceListPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setPrices')
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $this->priceProductPriceListPageSearchValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossPrice')
            ->willReturn(1);

        static::assertInstanceOf(PriceProductPriceListPageSearchTransfer::class, $this->priceGrouper->groupPricesData($this->priceProductPriceListPageSearchTransferMock, ['prices' => []]));
    }
}
