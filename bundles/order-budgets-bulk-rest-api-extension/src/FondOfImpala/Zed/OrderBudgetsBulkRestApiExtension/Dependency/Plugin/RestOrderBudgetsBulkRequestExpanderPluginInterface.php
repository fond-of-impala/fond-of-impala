<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

interface RestOrderBudgetsBulkRequestExpanderPluginInterface
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
