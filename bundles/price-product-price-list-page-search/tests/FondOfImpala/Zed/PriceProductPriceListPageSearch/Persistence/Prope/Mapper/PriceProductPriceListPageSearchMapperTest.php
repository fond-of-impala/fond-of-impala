<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\Prope\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\Propel\Mapper\PriceProductPriceListPageSearchMapper;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductPriceListPageSearchMapperTest extends Unit
{
    protected PriceProductPriceListPageSearchMapper $priceProductPriceListPageSearchMapper;

    protected MockObject|PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransferMock;

    protected array $priceProductPriceListsData;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListPageSearchTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListsData = [
            [
                'storeName' => 'name',
                'idProduct' => 1,
                'idPriceList' => 1,
            ],
        ];

        $this->priceProductPriceListPageSearchMapper = new PriceProductPriceListPageSearchMapper();
    }

    /**
     * @return void
     */
    public function testMapDataArrayToTransferArray(): void
    {
        static::assertIsArray($this->priceProductPriceListPageSearchMapper->mapDataArrayToTransferArray($this->priceProductPriceListsData));
    }
}
