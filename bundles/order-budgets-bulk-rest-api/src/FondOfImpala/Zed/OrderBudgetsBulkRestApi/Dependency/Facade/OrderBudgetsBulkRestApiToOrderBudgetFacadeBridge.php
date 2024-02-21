<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade;

use FondOfOryx\Zed\OrderBudget\Business\OrderBudgetFacadeInterface;
use Generated\Shared\Transfer\OrderBudgetTransfer;

class OrderBudgetsBulkRestApiToOrderBudgetFacadeBridge implements OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface
{
    protected OrderBudgetFacadeInterface $orderBudgetFacade;

    /**
     * @param \FondOfOryx\Zed\OrderBudget\Business\OrderBudgetFacadeInterface $orderBudgetFacade
     */
    public function __construct(OrderBudgetFacadeInterface $orderBudgetFacade)
    {
        $this->orderBudgetFacade = $orderBudgetFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderBudgetTransfer $orderBudgetTransfer
     *
     * @return void
     */
    public function updateOrderBudget(OrderBudgetTransfer $orderBudgetTransfer): void
    {
        $this->orderBudgetFacade->updateOrderBudget($orderBudgetTransfer);
    }
}
