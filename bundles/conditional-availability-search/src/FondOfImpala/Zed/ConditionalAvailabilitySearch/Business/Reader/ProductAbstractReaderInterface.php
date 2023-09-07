<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Reader;

interface ProductAbstractReaderInterface
{
    /**
     * @param array<int> $concreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByConcreteIds(array $concreteIds): array;
}
