<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader;

interface CompanyReaderInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $debtorNumbers
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferenceAndDebtorNumbers(string $customerReference, array $debtorNumbers): array;

    /**
     * @param string $customerReference
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByCustomerReferenceAndGroupedIdentifier(
        string $customerReference,
        array $groupedIdentifiers
    ): array;
}
