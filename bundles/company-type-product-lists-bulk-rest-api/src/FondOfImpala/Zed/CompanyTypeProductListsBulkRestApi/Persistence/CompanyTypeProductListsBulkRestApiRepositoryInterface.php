<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence;

interface CompanyTypeProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     * @param array<string> $colleagueReferences
     *
     * @return array<string, int>
     */
    public function getColleagueIdsByCustomerReferenceAndColleagueReferences(
        string $customerReference,
        array $colleagueReferences
    ): array;

    /**
     * @param string $customerReference
     * @param array<string> $colleagueEmails
     *
     * @return array<string, int>
     */
    public function getColleagueIdsByCustomerReferenceAndColleagueEmails(
        string $customerReference,
        array $colleagueEmails
    ): array;
}
