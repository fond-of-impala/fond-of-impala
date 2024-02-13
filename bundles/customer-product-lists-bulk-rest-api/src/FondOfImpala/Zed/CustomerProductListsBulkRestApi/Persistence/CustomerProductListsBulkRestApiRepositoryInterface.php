<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence;

interface CustomerProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param array<string> $customerReferences
     *
     * @return array<string, int>
     */
    public function getCustomerIdsByCustomerReferences(array $customerReferences): array;

    /**
     * @param array<string> $emails
     *
     * @return array<string, int>
     */
    public function getCustomerIdsByEmails(array $emails): array;
}
