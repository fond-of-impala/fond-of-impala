<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper;

use Generated\Shared\Transfer\OrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;

interface OrderBudgetMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
     *
     * @return \Generated\Shared\Transfer\OrderBudgetTransfer|null
     */
    public function fromRestOrderBudgetsBulkRequestOrderBudget(
        RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
    ): ?OrderBudgetTransfer;
}
