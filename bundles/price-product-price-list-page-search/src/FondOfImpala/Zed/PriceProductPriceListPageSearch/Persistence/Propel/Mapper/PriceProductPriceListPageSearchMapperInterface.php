<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\Propel\Mapper;

interface PriceProductPriceListPageSearchMapperInterface
{
    /**
     * @param array $priceProductPriceListsData
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function mapDataArrayToTransferArray(array $priceProductPriceListsData): array;
}
