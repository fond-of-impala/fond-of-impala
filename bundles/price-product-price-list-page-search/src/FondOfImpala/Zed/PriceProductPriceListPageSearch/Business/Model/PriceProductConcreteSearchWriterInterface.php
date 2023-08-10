<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

interface PriceProductConcreteSearchWriterInterface
{
    /**
     * @param int[] $priceProductPriceListIds
     *
     * @return void
     */
    public function publishConcretePriceProductPriceList(array $priceProductPriceListIds): void;

    /**
     * @param int[] $productIds
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
