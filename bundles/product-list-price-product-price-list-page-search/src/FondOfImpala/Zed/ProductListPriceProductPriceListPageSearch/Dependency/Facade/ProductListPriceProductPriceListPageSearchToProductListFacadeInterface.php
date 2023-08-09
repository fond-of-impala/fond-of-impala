<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

interface ProductListPriceProductPriceListPageSearchToProductListFacadeInterface
{
    /**
     * @param int $idProduct
     *
     * @return int[]
     */
    public function getProductBlacklistIdsByIdProduct(int $idProduct): array;

    /**
     * @param int $idProduct
     *
     * @return int[]
     */
    public function getProductWhitelistIdsByIdProduct(int $idProduct): array;

    /**
     * @param int $idProductAbstract
     *
     * @return int[]
     */
    public function getProductBlacklistIdsByIdProductAbstract(int $idProductAbstract): array;

    /**
     * @param int $idProductAbstract
     *
     * @return int[]
     */
    public function getProductWhitelistIdsByIdProductAbstract(int $idProductAbstract): array;
}
