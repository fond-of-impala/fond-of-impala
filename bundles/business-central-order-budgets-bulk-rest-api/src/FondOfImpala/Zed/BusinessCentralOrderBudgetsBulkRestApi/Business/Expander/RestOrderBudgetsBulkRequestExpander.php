<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter\DebtorNumbersFilterInterface;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

class RestOrderBudgetsBulkRequestExpander implements RestOrderBudgetsBulkRequestExpanderInterface
{
    protected DebtorNumbersFilterInterface $debtorNumbersFilter;

    protected OrderBudgetReaderInterface $companyReader;

    /**
     * @param \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter\DebtorNumbersFilterInterface $debtorNumbersFilter
     * @param \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface $companyReader
     */
    public function __construct(
        DebtorNumbersFilterInterface $debtorNumbersFilter,
        OrderBudgetReaderInterface $companyReader
    ) {
        $this->debtorNumbersFilter = $debtorNumbersFilter;
        $this->companyReader = $companyReader;
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function expand(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkRequestTransfer {
        $debtorNumbers = $this->debtorNumbersFilter->filterFromRestOrderBudgetsBulkRequest(
            $restOrderBudgetsBulkRequestTransfer,
        );

        $orderBudgetIds = [];
        $customerReference = $restOrderBudgetsBulkRequestTransfer->getCustomerReference();

        if ($customerReference !== null) {
            $orderBudgetIds = $this->companyReader->getIdsByCustomerReferenceAndDebtorNumbers(
                $customerReference,
                $debtorNumbers,
            );
        }

        $restProductListsBulkRequestAssignmentTransfers = $this->expandRestOrderBudgetsBulkRequestOrderBudgets(
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets(),
            $orderBudgetIds,
        );

        return $restOrderBudgetsBulkRequestTransfer->setOrderBudgets($restProductListsBulkRequestAssignmentTransfers);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer> $restOrderBudgetsBulkRequestOrderBudgetTransfers
     * @param array<string, int> $orderBudgetIds
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer>
     */
    protected function expandRestOrderBudgetsBulkRequestOrderBudgets(
        ArrayObject $restOrderBudgetsBulkRequestOrderBudgetTransfers,
        array $orderBudgetIds
    ): ArrayObject {
        foreach ($restOrderBudgetsBulkRequestOrderBudgetTransfers as $restOrderBudgetsBulkRequestOrderBudgetTransfer) {
            if ($restOrderBudgetsBulkRequestOrderBudgetTransfer->getId() !== null) {
                continue;
            }

            $restOrderBudgetsBulkRequestCompanyTransfer = $restOrderBudgetsBulkRequestOrderBudgetTransfer->getCompany();

            if ($restOrderBudgetsBulkRequestCompanyTransfer === null) {
                continue;
            }

            $debtorNumber = $restOrderBudgetsBulkRequestCompanyTransfer->getDebtorNumber();

            if ($debtorNumber === null) {
                continue;
            }

            if (!isset($orderBudgetIds[$debtorNumber])) {
                continue;
            }

            $restOrderBudgetsBulkRequestOrderBudgetTransfer->setId($orderBudgetIds[$debtorNumber]);
        }

        return $restOrderBudgetsBulkRequestOrderBudgetTransfers;
    }
}
