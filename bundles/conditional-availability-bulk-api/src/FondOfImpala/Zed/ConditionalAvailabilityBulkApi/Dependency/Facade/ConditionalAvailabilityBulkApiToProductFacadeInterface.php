<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade;

interface ConditionalAvailabilityBulkApiToProductFacadeInterface
{
    /**
     * @param array<string> $skus
     *
     * @return array<int>
     */
    public function getProductConcreteIdsByConcreteSkus(array $skus): array;
}
