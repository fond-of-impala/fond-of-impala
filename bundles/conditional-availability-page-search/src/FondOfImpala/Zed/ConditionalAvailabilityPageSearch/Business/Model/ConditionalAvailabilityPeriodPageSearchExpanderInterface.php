<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;

interface ConditionalAvailabilityPeriodPageSearchExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    public function expand(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer;
}
