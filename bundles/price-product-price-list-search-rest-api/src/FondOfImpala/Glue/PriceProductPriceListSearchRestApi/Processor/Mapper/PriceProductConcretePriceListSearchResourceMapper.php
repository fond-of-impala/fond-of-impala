<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper;

class PriceProductConcretePriceListSearchResourceMapper extends AbstractPriceProductPriceListSearchResourceMapper
{
    /**
     * @var string
     */
    protected const SEARCH_KEY_PRICES = 'price_product_concrete_price_lists';

    /**
     * @return string
     */
    protected function getPricesSearchKey(): string
    {
        return static::SEARCH_KEY_PRICES;
    }
}
