<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface;

class OrderBudgetReader implements OrderBudgetReaderInterface
{
    protected BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface $repository
     */
    public function __construct(BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $customerReference
     * @param array<string> $debtorNumbers
     *
     * @return array<string, int>
     */
    public function getIdsByCustomerReferenceAndDebtorNumbers(
        string $customerReference,
        array $debtorNumbers
    ): array {
        return $this->repository->getOrderBudgetIdsByCustomerReferenceAndDebtorNumbers($customerReference, $debtorNumbers);
    }
}
