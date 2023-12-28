<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;

class PriceProductConcretePriceListSearchQueryPluginTest extends Unit
{
    protected PriceProductConcretePriceListSearchQueryPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new PriceProductConcretePriceListSearchQueryPlugin();
    }

    /**
     * @return void
     */
    public function testGetSearchQuery(): void
    {
        static::assertInstanceOf(Query::class, $this->plugin->getSearchQuery());
    }

    /**
     * @return void
     */
    public function testSearchString(): void
    {
        $this->plugin->setSearchString('');

        static::assertSame('', $this->plugin->getSearchString());
    }
}
