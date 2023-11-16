<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

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
     * @param array<int>$conditionalAvailabilityIds
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function getConditionalAvailabilitiesByIds(
        array $conditionalAvailabilityIds
    ): ConditionalAvailabilityCollectionTransfer {
        return $this->conditionalAvailabilityFacade->getConditionalAvailabilitiesByIds($conditionalAvailabilityIds);
    }
}
