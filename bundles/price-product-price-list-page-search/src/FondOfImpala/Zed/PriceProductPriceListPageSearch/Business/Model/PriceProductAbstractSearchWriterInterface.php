<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

interface PriceProductAbstractSearchWriterInterface
{
    /**
     * @param array<int> $priceProductPriceListIds
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceList(array $priceProductPriceListIds): void;

    /**
     * @param array<int> $productAbstractIds
     *
     * @return void
     */
    public function publishAbstractPriceProductByByProductAbstractIds(array $productAbstractIds): void;

    /**
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceListByIdPriceList(int $idPriceList): void;
}
