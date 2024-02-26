<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

class UuidsFilter implements UuidsFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return array<string>
     */
    public function filterFromRestOrderBudgetsBulkRequest(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): array {
        return $this->filterFromRestOrderBudgetsBulkRequestOrderBudgets(
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets(),
        );
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer> $restOrderBudgetsBulkRequestOrderBudgetTransfers
     *
     * @return array<string>
     */
    public function filterFromRestOrderBudgetsBulkRequestOrderBudgets(
        ArrayObject $restOrderBudgetsBulkRequestOrderBudgetTransfers
    ): array {
        $uuids = [];

        foreach ($restOrderBudgetsBulkRequestOrderBudgetTransfers as $restOrderBudgetsBulkRequestOrderBudgetTransfer) {
            $uuid = $restOrderBudgetsBulkRequestOrderBudgetTransfer->getUuid();

            if ($uuid === null) {
                continue;
            }

            $uuids[] = $uuid;
        }

        return array_unique($uuids);
    }
}
