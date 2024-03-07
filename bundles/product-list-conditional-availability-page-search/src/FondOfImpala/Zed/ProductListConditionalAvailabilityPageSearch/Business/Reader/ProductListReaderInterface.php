<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Reader;

interface ProductListReaderInterface
{
    /**
     * @param int $idProduct
     *
     * @return array<int>
     */
    public function getBlacklistIdsByIdProduct(int $idProduct): array;

    /**
     * @param int $idProduct
     *
     * @return array<int>
     */
    public function getWhitelistIdsByIdProduct(int $idProduct): array;
}
