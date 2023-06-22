<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension;

use Codeception\Test\Unit;

class ProductListConditionalAvailabilityPeriodPageSearchDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension\ProductListConditionalAvailabilityPeriodPageSearchDataExpanderPlugin
     */
    protected $productListPageMapExpanderPlugin;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $productListMap;

    /**
     * @var array
     */
    protected $searchData;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListMap = [
            'blacklists' => [],
            'whitelists' => [1],
        ];

        $this->data = [
            'product_list_map' => $this->productListMap,
        ];

        $this->searchData = [];

        $this->productListPageMapExpanderPlugin = new ProductListConditionalAvailabilityPeriodPageSearchDataExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $searchData = $this->productListPageMapExpanderPlugin->expand($this->data, $this->searchData);

        $this->assertArrayHasKey('product-lists', $searchData);
        $this->assertEquals($this->productListMap, $searchData['product-lists']);
    }

    /**
     * @return void
     */
    public function testExpandEmpty(): void
    {
        $searchData = $this->productListPageMapExpanderPlugin->expand([], $this->searchData);

        $this->assertArrayNotHasKey('product-lists', $searchData);
    }
}
