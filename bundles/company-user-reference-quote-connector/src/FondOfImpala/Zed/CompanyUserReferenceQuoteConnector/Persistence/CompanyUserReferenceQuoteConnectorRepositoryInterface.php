<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence;

interface CompanyUserReferenceQuoteConnectorRepositoryInterface
{
    /**
     * @param array<string> $companyUserReferences
     *
     * @return array<int>
     */
    public function findQuoteIdsByCompanyUserReferences(array $companyUserReferences): array;

    /**
     * @param string $companyUserReference
     *
     * @return array<int>
     */
    public function findQuoteIdsByCompanyUserReference(string $companyUserReference): array;
}
