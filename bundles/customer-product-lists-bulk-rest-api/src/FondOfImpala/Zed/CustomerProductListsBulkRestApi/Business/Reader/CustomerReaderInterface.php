<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader;

interface CustomerReaderInterface
{
    /**
     * @param array<string> $customerReferences
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferences(array $customerReferences): array;

    /**
     * @param array<string> $emails
     *
     * @return array<int>
     */
    public function getIdsByEmails(array $emails): array;

    /**
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByGroupedIdentifier(array $groupedIdentifiers): array;
}
