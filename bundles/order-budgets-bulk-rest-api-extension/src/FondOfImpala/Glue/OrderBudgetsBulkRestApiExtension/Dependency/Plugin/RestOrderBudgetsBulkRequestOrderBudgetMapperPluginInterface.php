<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;

interface RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer
     */
    public function mapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget(
        RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer,
        RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
    ): RestOrderBudgetsBulkRequestOrderBudgetTransfer;
}
