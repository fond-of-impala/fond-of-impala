<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;

class PriceProductAbstractPriceListSearchQueryPluginTest extends Unit
{
    protected PriceProductAbstractPriceListSearchQueryPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new PriceProductAbstractPriceListSearchQueryPlugin();
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
