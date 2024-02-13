<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence;

interface CompanyProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getCompanyIdsByCustomerReferenceAndUuids(
        string $customerReference,
        array $uuids
    ): array;

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
