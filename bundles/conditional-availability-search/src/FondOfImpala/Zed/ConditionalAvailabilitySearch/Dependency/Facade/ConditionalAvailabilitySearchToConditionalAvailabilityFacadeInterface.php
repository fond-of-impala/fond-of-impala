<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade;

use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

interface ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
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
