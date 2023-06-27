<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge implements ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface
{
    protected ConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade
     */
    public function __construct(ConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacade)
    {
        $this->conditionalAvailabilityFacade = $conditionalAvailabilityFacade;
    }

    /**
     * @param array<int> $productConcreteIds
     *
     * @return array<int>
     */
    public function getConditionalAvailabilityIdsByProductConcreteIds(array $productConcreteIds): array
    {
        return $this->conditionalAvailabilityFacade->getConditionalAvailabilityIdsByProductConcreteIds(
            $productConcreteIds,
        );
    }
}
