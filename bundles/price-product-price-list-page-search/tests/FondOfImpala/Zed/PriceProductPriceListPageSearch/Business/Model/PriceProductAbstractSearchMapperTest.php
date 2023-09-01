<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductAbstractSearchMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchMapper
     */
    protected PriceProductAbstractSearchMapper $priceProductAbstractSearchMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface
     */
    protected MockObject|PriceProductPriceListPageSearchToStoreFacadeInterface $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface[]
     */
    protected array $priceProductAbstractPriceListPageDataExpanderPluginMocks;

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

        $this->priceProductAbstractPriceListPageDataExpanderPluginMocks = [
            $this->getMockBuilder(PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->priceProductAbstractSearchMapper = new PriceProductAbstractSearchMapper(
            $this->storeFacadeMock,
            $this->priceProductAbstractPriceListPageDataExpanderPluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testMapTransferToSearchData(): void
    {
        $this->storeFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('DE');

        $this->priceProductAbstractPriceListPageDataExpanderPluginMocks[0]->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturnArgument(1);

        $searchData = $this->priceProductAbstractSearchMapper->mapDataToSearchData(
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

        static::assertArrayHasKey('id-price-list', $searchData);
        static::assertArrayHasKey('price-list-name', $searchData);
        static::assertArrayHasKey('search-result-data', $searchData);
    }
}
