<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;

interface OrderBudgetPersisterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
     *
     * @return void
     */
    public function persist(
        RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
    ): void;
}
