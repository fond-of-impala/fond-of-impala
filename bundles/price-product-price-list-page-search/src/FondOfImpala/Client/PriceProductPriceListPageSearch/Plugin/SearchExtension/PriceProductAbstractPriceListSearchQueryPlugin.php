<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

class PriceProductAbstractPriceListSearchQueryPlugin extends AbstractPriceProductPriceListSearchQueryPlugin
{
    /**
     * @var string
     */
    protected const TYPE = 'abstract';

    /**
     * @return string
     */
    protected function getType(): string
    {
        return static::TYPE;
    }
}
