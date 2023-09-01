<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension;

use Codeception\Test\Unit;

class ProductListPriceProductConcretePriceListPageSearchDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension\ProductListPriceProductConcretePriceListPageSearchDataExpanderPlugin
     */
    protected ProductListPriceProductConcretePriceListPageSearchDataExpanderPlugin $productListPriceProductConcretePriceListPageSearchDataExpanderPlugin;

    /**
     * @var array
     */
    protected array $data;

    /**
     * @var array
     */
    protected array $productListMap;

    /**
     * @var array
     */
    protected array $searchData;

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

        $this->productListPriceProductConcretePriceListPageSearchDataExpanderPlugin = new ProductListPriceProductConcretePriceListPageSearchDataExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $searchData = $this->productListPriceProductConcretePriceListPageSearchDataExpanderPlugin
            ->expand($this->data, $this->searchData);

        self::assertArrayHasKey('product-lists', $searchData);
        self::assertEquals($this->productListMap, $searchData['product-lists']);
    }

    /**
     * @return void
     */
    public function testExpandEmpty(): void
    {
        $searchData = $this->productListPriceProductConcretePriceListPageSearchDataExpanderPlugin
            ->expand([], $this->searchData);

        self::assertArrayNotHasKey('product-lists', $searchData);
    }
}
