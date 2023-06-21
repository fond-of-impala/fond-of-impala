<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use ArrayObject;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

interface GroupedConditionalAvailabilityReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function find(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ArrayObject;
}
