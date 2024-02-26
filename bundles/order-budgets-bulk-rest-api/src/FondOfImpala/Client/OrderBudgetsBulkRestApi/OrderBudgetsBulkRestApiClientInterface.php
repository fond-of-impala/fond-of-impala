<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;

interface OrderBudgetsBulkRestApiClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer
     */
    public function bulkProcess(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkResponseTransfer;
}
