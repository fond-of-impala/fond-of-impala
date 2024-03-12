<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Plugin\PriceProductPriceListSearchRestApi;

/**
 * @method \FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory getFactory()
 * @method \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClientInterface getClient()
 */
class ProductAbstractPriceListToCompanyCurrencyReducerPlugin extends AbstractPriceListToCompanyCurrencyReducerPlugin
{
    /**
     * @var string
     */
    protected const INDEX = 'price_product_abstract_price_lists';
}
