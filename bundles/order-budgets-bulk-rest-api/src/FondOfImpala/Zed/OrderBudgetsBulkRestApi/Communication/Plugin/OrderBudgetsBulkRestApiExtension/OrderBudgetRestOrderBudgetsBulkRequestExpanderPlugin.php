<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension;

use FondOfImpala\Zed\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestExpanderPluginInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\OrderBudgetsBulkRestApiFacadeInterface getFacade()
 */
class OrderBudgetRestOrderBudgetsBulkRequestExpanderPlugin extends AbstractPlugin implements RestOrderBudgetsBulkRequestExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function expand(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkRequestTransfer {
        return $this->getFacade()->expandRestOrderBudgetsBulkRequest($restOrderBudgetsBulkRequestTransfer);
    }
}
