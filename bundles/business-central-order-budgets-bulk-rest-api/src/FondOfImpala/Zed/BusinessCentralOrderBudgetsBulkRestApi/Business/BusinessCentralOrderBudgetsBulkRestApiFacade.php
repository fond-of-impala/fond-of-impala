<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\BusinessCentralOrderBudgetsBulkRestApiBusinessFactory getFactory()
 */
class BusinessCentralOrderBudgetsBulkRestApiFacade extends AbstractFacade implements BusinessCentralOrderBudgetsBulkRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function expandRestOrderBudgetsBulkRequest(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkRequestTransfer {
        return $this->getFactory()->createRestOrderBudgetsBulkRequestExpander()
            ->expand($restOrderBudgetsBulkRequestTransfer);
    }
}
