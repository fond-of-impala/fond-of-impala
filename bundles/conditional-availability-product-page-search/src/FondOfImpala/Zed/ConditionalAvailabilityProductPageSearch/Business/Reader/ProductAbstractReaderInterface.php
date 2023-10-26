<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader;

interface ProductAbstractReaderInterface
{
    /**
     * @param array<int> $concreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByConcreteIds(array $concreteIds): array;
}
