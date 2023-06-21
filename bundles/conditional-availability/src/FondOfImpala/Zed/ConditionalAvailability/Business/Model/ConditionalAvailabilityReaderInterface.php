<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

interface ConditionalAvailabilityReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function findById(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function find(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ConditionalAvailabilityCollectionTransfer;

    /**
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findAll(): ConditionalAvailabilityCollectionTransfer;
}
