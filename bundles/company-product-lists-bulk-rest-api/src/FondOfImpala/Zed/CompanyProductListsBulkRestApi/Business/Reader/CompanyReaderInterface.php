<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader;

interface CompanyReaderInterface
{
    /**
     * @param array<string> $uuids
     *
     * @return array<int>
     */
    public function getIdsByUuids(array $uuids): array;

    /**
     * @param array<string> $debtorNumbers
     *
     * @return array<int>
     */
    public function getIdsByDebtorNumbers(array $debtorNumbers): array;

    /**
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByGroupedIdentifier(array $groupedIdentifiers): array;
}
