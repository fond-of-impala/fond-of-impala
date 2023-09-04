<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade;

interface ConditionalAvailabilitySearchToProductFacadeInterface
{
    /**
     *
     * @param array<int> $productConcreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByProductConcreteIds(array $productConcreteIds): array;

    /**
     * @param int $idProductAbstract
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function getConcreteProductsByAbstractProductId(int $idProductAbstract): array;
}
