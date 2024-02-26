<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\OrderBudgetsBulkRestApiBusinessFactory getFactory()
 */
class OrderBudgetsBulkRestApiFacade extends AbstractFacade implements OrderBudgetsBulkRestApiFacadeInterface
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

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer
     */
    public function bulkProcess(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkResponseTransfer {
        return $this->getFactory()->createBulkProcessor()
            ->process($restOrderBudgetsBulkRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
     *
     * @return void
     */
    public function persistOrderBudget(
        RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
    ): void {
        $this->getFactory()->createOrderBudgetPersister()
            ->persist($restOrderBudgetsBulkRequestOrderBudgetTransfer);
    }
}
