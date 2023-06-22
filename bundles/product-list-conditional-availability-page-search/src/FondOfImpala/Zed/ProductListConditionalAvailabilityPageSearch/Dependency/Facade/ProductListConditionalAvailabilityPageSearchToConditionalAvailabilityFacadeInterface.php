<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

interface ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface
{
    /**
     * @param array<int> $productConcreteIds
     *
     * @return array<int>
     */
    public function getConditionalAvailabilityIdsByProductConcreteIds(array $productConcreteIds): array;
}
