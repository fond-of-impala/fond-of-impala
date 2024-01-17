<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use ArrayObject;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

class ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeBridge implements ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
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
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findConditionalAvailabilities(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ConditionalAvailabilityCollectionTransfer {
        return $this->conditionalAvailabilityFacade
            ->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);
    }

    /**
     * @param array<int> $productAbstractIds
     *
     * @return \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function findGroupedConditionalAvailabilitiesByProductAbstractIds(
        array $productAbstractIds
    ): ArrayObject {
        return $this->conditionalAvailabilityFacade->findGroupedConditionalAvailabilitiesByProductAbstractIds(
            $productAbstractIds,
        );
    }
}
