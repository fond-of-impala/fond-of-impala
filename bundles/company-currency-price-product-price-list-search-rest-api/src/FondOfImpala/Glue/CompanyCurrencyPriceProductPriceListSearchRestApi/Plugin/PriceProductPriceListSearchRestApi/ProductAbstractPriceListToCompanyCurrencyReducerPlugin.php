<?php

namespace FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\Plugin\PriceProductPriceListSearchRestApi;

/**
 * @method \FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiFactory getFactory()
 * @method \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiClientInterface getClient()
 */
class ProductAbstractPriceListToCompanyCurrencyReducerPlugin extends AbstractPriceListToCompanyCurrencyReducerPlugin
{
    /**
     * @var string
     */
    protected const INDEX = 'price_product_abstract_price_lists';
}
