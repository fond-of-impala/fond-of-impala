<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;

class PriceProductConcretePriceListSearchQueryPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\PriceProductConcretePriceListSearchQueryPlugin
     */
    protected PriceProductConcretePriceListSearchQueryPlugin $priceProductConcretePriceListSearchQueryPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductConcretePriceListSearchQueryPlugin = new PriceProductConcretePriceListSearchQueryPlugin();
    }

    /**
     * @return void
     */
    public function testGetSearchQuery(): void
    {
        static::assertInstanceOf(Query::class, $this->priceProductConcretePriceListSearchQueryPlugin->getSearchQuery());
    }

    /**
     * @return void
     */
    public function testSearchString(): void
    {
        $this->priceProductConcretePriceListSearchQueryPlugin->setSearchString('');

        static::assertSame('', $this->priceProductConcretePriceListSearchQueryPlugin->getSearchString());
    }
}
