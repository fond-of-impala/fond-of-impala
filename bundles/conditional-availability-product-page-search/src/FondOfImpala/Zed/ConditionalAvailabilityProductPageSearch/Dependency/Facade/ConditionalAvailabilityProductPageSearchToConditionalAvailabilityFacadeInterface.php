<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

interface ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findConditionalAvailabilities(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ConditionalAvailabilityCollectionTransfer;
}
