<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

interface PriceProductConcreteSearchWriterInterface
{
    /**
     * @param array<int> $priceProductPriceListIds
     *
     * @return void
     */
    public function publishConcretePriceProductPriceList(array $priceProductPriceListIds): void;

    /**
     * @param array<int> $productIds
     *
     * @return void
     */
    public function publishConcretePriceProductByProductIds(array $productIds): void;

    /**
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishConcretePriceProductPriceListByIdPriceList(int $idPriceList): void;
}
