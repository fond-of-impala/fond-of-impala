<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence;

interface CompanyProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getCompanyIdsByUuids(array $uuids): array;

    /**
     * @param array<string> $debtorNumbers
     *
     * @return array<string, int>
     */
    public function getCompanyIdsByDebtorNumbers(array $debtorNumbers): array;
}
