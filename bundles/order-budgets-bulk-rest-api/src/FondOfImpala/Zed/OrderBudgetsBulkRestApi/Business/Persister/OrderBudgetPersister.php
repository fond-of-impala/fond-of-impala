<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper\OrderBudgetMapperInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;

class OrderBudgetPersister implements OrderBudgetPersisterInterface
{
    protected OrderBudgetMapperInterface $orderBudgetMapper;

    protected OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface $orderBudgetFacade;

    /**
     * @param \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper\OrderBudgetMapperInterface $orderBudgetMapper
     * @param \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface $orderBudgetFacade
     */
    public function __construct(
        OrderBudgetMapperInterface $orderBudgetMapper,
        OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface $orderBudgetFacade
    ) {
        $this->orderBudgetMapper = $orderBudgetMapper;
        $this->orderBudgetFacade = $orderBudgetFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
     *
     * @return void
     */
    public function persist(RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer): void
    {
        $orderBudgetTransfer = $this->orderBudgetMapper->fromRestOrderBudgetsBulkRequestOrderBudget(
            $restOrderBudgetsBulkRequestOrderBudgetTransfer,
        );

        if ($orderBudgetTransfer === null) {
            return;
        }

        $this->orderBudgetFacade->updateOrderBudget($orderBudgetTransfer);
    }
}
