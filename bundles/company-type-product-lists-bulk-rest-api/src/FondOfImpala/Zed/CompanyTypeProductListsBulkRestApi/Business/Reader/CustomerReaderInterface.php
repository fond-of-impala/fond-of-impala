<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Reader;

interface CustomerReaderInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $colleagueReferences
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferenceAndColleagueReferences(
        string $customerReference,
        array $colleagueReferences
    ): array;

    /**
     * @param string $customerReference
     * @param array<string> $colleagueEmails
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferenceAndColleagueEmails(
        string $customerReference,
        array $colleagueEmails
    ): array;

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
