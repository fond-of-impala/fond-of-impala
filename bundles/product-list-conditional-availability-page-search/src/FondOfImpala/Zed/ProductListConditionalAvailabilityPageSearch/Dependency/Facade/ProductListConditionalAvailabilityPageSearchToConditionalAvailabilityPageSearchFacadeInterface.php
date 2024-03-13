<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

interface ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface
{
    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function publishByConditionalAvailabilityIds(array $conditionalAvailabilityIds): void;
}
