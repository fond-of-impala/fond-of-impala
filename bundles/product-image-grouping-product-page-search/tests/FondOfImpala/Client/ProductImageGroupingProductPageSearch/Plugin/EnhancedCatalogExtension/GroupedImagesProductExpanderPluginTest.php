<?php

namespace FondOfImpala\Client\ProductImageGroupingProductPageSearch\Plugin\EnhancedCatalogExtension;

use Codeception\Test\Unit;
use Elastica\Result;
use Elastica\ResultSet;
use FondOfImpala\Client\ProductImageGroupingProductPageSearch\Plugin\Search\RawCatalogSearchResultFormatterPlugin;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch\ProductImageGroupMapExpanderPlugin;
use Generated\Shared\Search\PageIndexMap;
use PHPUnit\Framework\MockObject\MockObject;

class GroupedImagesProductExpanderPluginTest extends Unit
{
    protected MockObject|Result $resultMock;

    protected GroupedImagesProductExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resultMock = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new GroupedImagesProductExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testFormatSearchResult(): void
    {
        $product = [
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

        $product = $this->plugin->expand($product, $this->resultMock);

        static::assertArrayHasKey(ProductImageGroupMapExpanderPlugin::KEY, $product);
        static::assertArrayHasKey('frontView', $product[ProductImageGroupMapExpanderPlugin::KEY]);
        static::assertCount(1, $product[ProductImageGroupMapExpanderPlugin::KEY]['frontView']);
        static::assertArrayHasKey('topView', $product[ProductImageGroupMapExpanderPlugin::KEY]);
        static::assertCount(2, $product[ProductImageGroupMapExpanderPlugin::KEY]['topView']);
        static::assertEquals(99, $product[ProductImageGroupMapExpanderPlugin::KEY]['topView'][1]['sortOrder']);
    }
}
