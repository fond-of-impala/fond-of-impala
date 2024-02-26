<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

interface RestOrderBudgetsBulkRequestExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function expand(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkRequestTransfer;
}
