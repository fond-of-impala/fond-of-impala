<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;

class PriceProductAbstractPriceListSearchQueryPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\PriceProductAbstractPriceListSearchQueryPlugin
     */
    protected $priceProductAbstractPriceListSearchQueryPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductAbstractPriceListSearchQueryPlugin = new PriceProductAbstractPriceListSearchQueryPlugin();
    }

    /**
     * @return void
     */
    public function testGetSearchQuery(): void
    {
        $this->assertInstanceOf(Query::class, $this->priceProductAbstractPriceListSearchQueryPlugin->getSearchQuery());
    }

    /**
     * @return void
     */
    public function testSearchString(): void
    {
        $this->priceProductAbstractPriceListSearchQueryPlugin->setSearchString('');

        $this->assertSame('', $this->priceProductAbstractPriceListSearchQueryPlugin->getSearchString());
    }
}
