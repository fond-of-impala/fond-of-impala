<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper;

use Generated\Shared\Transfer\OrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;

class OrderBudgetMapper implements OrderBudgetMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
     *
     * @return \Generated\Shared\Transfer\OrderBudgetTransfer|null
     */
    public function fromRestOrderBudgetsBulkRequestOrderBudget(
        RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
    ): ?OrderBudgetTransfer {
        $idOrderBudget = $restOrderBudgetsBulkRequestOrderBudgetTransfer->getId();

        if ($idOrderBudget === null) {
            return null;
        }

        $nextInitialBudget = $restOrderBudgetsBulkRequestOrderBudgetTransfer->getNextInitialBudget();

        if ($nextInitialBudget === null) {
            return null;
        }

        return (new OrderBudgetTransfer())->setIdOrderBudget($idOrderBudget)
            ->setNextInitialBudget($nextInitialBudget);
    }
}
