<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

interface UuidsFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return array<string>
     */
    public function filterFromRestOrderBudgetsBulkRequest(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): array;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer> $restOrderBudgetsBulkRequestOrderBudgetTransfers
     *
     * @return array<string>
     */
    public function filterFromRestOrderBudgetsBulkRequestOrderBudgets(
        ArrayObject $restOrderBudgetsBulkRequestOrderBudgetTransfers
    ): array;
}
