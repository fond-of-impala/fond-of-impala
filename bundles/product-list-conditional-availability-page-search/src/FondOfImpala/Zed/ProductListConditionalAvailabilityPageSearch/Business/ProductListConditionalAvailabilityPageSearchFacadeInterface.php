<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;

interface ProductListConditionalAvailabilityPageSearchFacadeInterface
{
    /**
     * Specification:
     *  - Expands ConditionalAvailabilityPeriodPageSearchTransfer with product lists data and returns the modified object.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    public function expandConditionalAvailabilityPeriodPageSearchTransferWithProductLists(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer;
}
