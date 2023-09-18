<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

interface ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
{
    /**
     * @param array<int> $productAbstractIds
     *
     * @return void
     */
    public function publish(array $productAbstractIds): void;

    /**
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    public function publishProductConcretes(array $productConcreteIds): void;
}
