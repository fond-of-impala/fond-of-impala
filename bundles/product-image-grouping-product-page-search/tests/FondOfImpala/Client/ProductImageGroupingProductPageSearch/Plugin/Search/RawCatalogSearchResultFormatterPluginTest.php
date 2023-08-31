<?php

namespace FondOfImpala\Client\ProductImageGroupingProductPageSearch\Plugin\Search;

use Codeception\Test\Unit;
use Elastica\Result;
use Elastica\ResultSet;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch\ProductImageGroupMapExpanderPlugin;
use Generated\Shared\Search\PageIndexMap;
use PHPUnit\Framework\MockObject\MockObject;

class RawCatalogSearchResultFormatterPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ProductImageGroupingProductPageSearch\Plugin\Search\RawCatalogSearchResultFormatterPlugin
     */
    protected RawCatalogSearchResultFormatterPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\ResultSet
     */
    protected MockObject|ResultSet $resultSetMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Result
     */
    protected MockObject|Result $resultMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultMock = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new RawCatalogSearchResultFormatterPlugin();
    }

    /**
     * @return void
     */
    public function testFormatSearchResult(): void
    {
        $productData = [
            ProductImageGroupMapExpanderPlugin::KEY => [
                'front_view' => [
                    0 => [
                        'external_url_small' => "https:\/\/...",
                        'external_url_large' => "https:\/\/...",
                        'sort_order' => 0,
                    ],
                ],
                'top_view' => [
                    0 => [
                        'external_url_small' => "https:\/\/...",
                        'external_url_large' => "https:\/\/...",
                        'sort_order' => 0,
                    ],
                    1 => [
                        'external_url_small' => "https:\/\/...",
                        'external_url_large' => "https:\/\/...",
                        'sort_order' => 99,
                    ],
                ],
            ],
        ];
        $this->resultSetMock->expects(static::atLeastOnce())->method('getResults')->willReturn([$this->resultMock]);
        $this->resultMock->expects(static::atLeastOnce())->method('getSource')->willReturn([PageIndexMap::SEARCH_RESULT_DATA => $productData]);
        $data = $this->plugin->formatSearchResult($this->resultSetMock, []);

        static::assertArrayHasKey(ProductImageGroupMapExpanderPlugin::KEY, $data[0]);
        static::assertArrayHasKey('frontView', $data[0][ProductImageGroupMapExpanderPlugin::KEY]);
        static::assertCount(1, $data[0][ProductImageGroupMapExpanderPlugin::KEY]['frontView']);
        static::assertArrayHasKey('topView', $data[0][ProductImageGroupMapExpanderPlugin::KEY]);
        static::assertCount(2, $data[0][ProductImageGroupMapExpanderPlugin::KEY]['topView']);
        static::assertEquals(99, $data[0][ProductImageGroupMapExpanderPlugin::KEY]['topView'][1]['sort_order']);
    }
}
