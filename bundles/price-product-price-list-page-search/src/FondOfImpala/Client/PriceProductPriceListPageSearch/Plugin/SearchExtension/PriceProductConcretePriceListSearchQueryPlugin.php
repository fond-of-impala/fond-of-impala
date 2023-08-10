<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

class PriceProductConcretePriceListSearchQueryPlugin extends AbstractPriceProductPriceListSearchQueryPlugin
{
    /**
     * @var string
     */
    protected const TYPE = 'concrete';

    /**
     * @return string
     */
    protected function getType(): string
    {
        return static::TYPE;
    }
}
