<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade;

use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;

interface ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
{
    /**
     * @param array<int> $conditionalAvailabilitiesIds
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findConditionalAvailabilities(array $conditionalAvailabilitiesIds): ConditionalAvailabilityCollectionTransfer;
}
