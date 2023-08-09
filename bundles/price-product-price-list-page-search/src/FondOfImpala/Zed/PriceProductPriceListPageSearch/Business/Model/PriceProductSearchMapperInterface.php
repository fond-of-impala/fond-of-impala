<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

interface PriceProductSearchMapperInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function mapDataToSearchData(array $data): array;
}
