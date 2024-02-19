<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence;

/**
 * @codeCoverageIgnore
 */
interface BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $debtorNumbers
     *
     * @return array<string, int>
     */
    public function getOrderBudgetIdsByCustomerReferenceAndDebtorNumbers(
        string $customerReference,
        array $debtorNumbers
    ): array;
}
