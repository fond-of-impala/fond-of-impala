<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Reducer;

interface PriceDataReducerPluginExecutorInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function execute(array $data): array;
}
