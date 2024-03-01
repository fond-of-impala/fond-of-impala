<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader;

interface ProductListReaderInterface
{
    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function getIdsByIdCustomer(int $idCustomer): array;
}
