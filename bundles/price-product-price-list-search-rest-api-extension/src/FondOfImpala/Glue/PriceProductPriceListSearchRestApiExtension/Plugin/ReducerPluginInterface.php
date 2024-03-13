<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin;

interface ReducerPluginInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function reduce(array $data): array;
}
