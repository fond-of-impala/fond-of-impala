<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence;

interface BusinessCentralProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $debtorNumbers
     *
     * @return array<string, int>
     */
    public function getCompanyIdsByCustomerReferenceAndDebtorNumbers(
        string $customerReference,
        array $debtorNumbers
    ): array;
}
