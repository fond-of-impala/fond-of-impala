<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

interface PriceListApiToProductFacadeInterface
{
    /**
     * @param array<string> $skus
     *
     * @return array<int>
     */
    public function getProductConcreteIdsByConcreteSkus(array $skus): array;
}
