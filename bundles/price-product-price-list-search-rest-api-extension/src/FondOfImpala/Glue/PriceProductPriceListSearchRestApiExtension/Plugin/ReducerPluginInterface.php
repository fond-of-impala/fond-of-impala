<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin;

/**
 * @method \FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory getFactory()
 */
interface ReducerPluginInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function reduce(array $data): array;
}
