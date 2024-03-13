<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension;

use Codeception\Test\Unit;

class ProductListConditionalAvailabilityPeriodPageSearchDataExpanderPluginTest extends Unit
{
    protected ProductListConditionalAvailabilityPeriodPageSearchDataExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->plugin = new ProductListConditionalAvailabilityPeriodPageSearchDataExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $productListMap = [
            'blacklists' => [],
            'whitelists' => [1],
        ];
        $data = ['product_list_map' => $productListMap];
        $searchData = [];

        $searchData = $this->plugin->expand($data, $searchData);

        static::assertArrayHasKey('product-lists', $searchData);
        static::assertEquals($productListMap, $searchData['product-lists']);
    }

    /**
     * @return void
     */
    public function testExpandEmpty(): void
    {
        $searchData = $this->plugin->expand([], []);

        static::assertArrayNotHasKey('product-lists', $searchData);
    }
}
