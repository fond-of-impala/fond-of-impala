<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageSearchDataExpanderPluginInterface;
use Generated\Shared\Transfer\StoreTransfer;

class PriceProductConcreteSearchMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchMapper
     */
    protected $priceProductConcreteSearchMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface
     */
    protected $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected $storeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageSearchDataExpanderPluginInterface[]
     */
    protected $priceProductConcretePriceListPageDataExpanderPluginMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->storeFacadeMock = $this->getMockBuilder(PriceProductPriceListPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductConcretePriceListPageDataExpanderPluginMocks = [
            $this->getMockBuilder(PriceProductConcretePriceListPageSearchDataExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->priceProductConcreteSearchMapper = new PriceProductConcreteSearchMapper(
            $this->storeFacadeMock,
            $this->priceProductConcretePriceListPageDataExpanderPluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testMapTransferToSearchData(): void
    {
        $this->storeFacadeMock->expects($this->atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('DE');

        $this->priceProductConcretePriceListPageDataExpanderPluginMocks[0]->expects($this->atLeastOnce())
            ->method('expand')
            ->willReturnArgument(1);

        $searchData = $this->priceProductConcreteSearchMapper->mapDataToSearchData(
            [
                'sku' => 'SKU',
                'price_list_name' => 'GOLD',
                'id_price_list' => 1,
                'store' => 'EROTS',
                'prices' => [
                    'EUR' => [
                        'price_data' => [
                            'NET_MODE' => [
                                'DEFAULT' => 3350,
                            ],
                        ],
                    ],
                ],
            ],
        );

        $this->assertArrayHasKey('id-price-list', $searchData);
        $this->assertArrayHasKey('price-list-name', $searchData);
        $this->assertArrayHasKey('search-result-data', $searchData);
    }
}
