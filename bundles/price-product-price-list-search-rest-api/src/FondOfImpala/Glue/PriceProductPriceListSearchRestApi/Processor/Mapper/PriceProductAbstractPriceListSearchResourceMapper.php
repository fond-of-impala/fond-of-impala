<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper;

class PriceProductAbstractPriceListSearchResourceMapper extends AbstractPriceProductPriceListSearchResourceMapper
{
    /**
     * @var string
     */
    protected const SEARCH_KEY_PRICES = 'price_product_abstract_price_lists';

    /**
     * @return string
     */
    protected function getPricesSearchKey(): string
    {
        return static::SEARCH_KEY_PRICES;
    }
}
