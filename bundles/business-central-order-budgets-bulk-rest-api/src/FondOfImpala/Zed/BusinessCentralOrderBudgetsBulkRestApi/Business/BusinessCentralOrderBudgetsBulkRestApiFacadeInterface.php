<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

interface BusinessCentralOrderBudgetsBulkRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function expandRestOrderBudgetsBulkRequest(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkRequestTransfer;
}
