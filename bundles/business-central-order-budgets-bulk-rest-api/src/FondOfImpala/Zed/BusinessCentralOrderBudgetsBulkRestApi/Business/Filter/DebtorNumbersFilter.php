<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

class DebtorNumbersFilter implements DebtorNumbersFilterInterface
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
        $debtorNumbers = [];

        foreach ($restOrderBudgetsBulkRequestOrderBudgetTransfers as $restOrderBudgetsBulkRequestOrderBudgetTransfer) {
            $restOrderBudgetsBulkRequestCompanyTransfer = $restOrderBudgetsBulkRequestOrderBudgetTransfer->getCompany();

            if ($restOrderBudgetsBulkRequestCompanyTransfer === null) {
                continue;
            }

            $debtorNumber = $restOrderBudgetsBulkRequestCompanyTransfer->getDebtorNumber();

            if ($debtorNumber === null) {
                continue;
            }

            $debtorNumbers[] = $debtorNumber;
        }

        return $debtorNumbers;
    }
}
