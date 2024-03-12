<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Plugin\PriceProductPriceListSearchRestApi;

use Exception;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin\ReducerPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;
use Throwable;

/**
 * @method \FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory getFactory()
 * @method \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClientInterface  getClient()
 */
class ProductAbstractPriceListToCompanyCurrencyReducerPlugin extends AbstractPriceListToCompanyCurrencyReducerPlugin
{
    protected const INDEX = 'price_product_abstract_price_lists';
}
