<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;

interface RestOrderBudgetsBulkRequestOrderBudgetMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer
     */
    public function fromRestOrderBudgetsBulkOrderBudget(
        RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer
    ): RestOrderBudgetsBulkRequestOrderBudgetTransfer;
}
