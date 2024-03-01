<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader;

interface CompanyReaderInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $uuids
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferenceAndUuids(string $customerReference, array $uuids): array;

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
