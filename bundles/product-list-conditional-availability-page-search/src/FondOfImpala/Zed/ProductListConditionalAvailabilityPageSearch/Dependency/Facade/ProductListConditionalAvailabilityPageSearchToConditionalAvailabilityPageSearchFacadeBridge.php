<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridge implements ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeInterface
{
    protected ConditionalAvailabilityPageSearchFacadeInterface $conditionalAvailabilityPageSearchFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface $conditionalAvailabilityPageSearchFacade
     */
    public function __construct(
        ConditionalAvailabilityPageSearchFacadeInterface $conditionalAvailabilityPageSearchFacade
    ) {
        $this->conditionalAvailabilityPageSearchFacade = $conditionalAvailabilityPageSearchFacade;
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function publishByConditionalAvailabilityIds(array $conditionalAvailabilityIds): void
    {
        $this->conditionalAvailabilityPageSearchFacade->publishByConditionalAvailabilityIds(
            $conditionalAvailabilityIds,
        );
    }
}
