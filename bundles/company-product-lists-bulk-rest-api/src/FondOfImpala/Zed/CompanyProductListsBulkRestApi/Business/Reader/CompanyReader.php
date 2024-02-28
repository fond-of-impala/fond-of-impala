<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence\CompanyProductListsBulkRestApiRepositoryInterface;

class CompanyReader implements CompanyReaderInterface
{
    protected CompanyProductListsBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence\CompanyProductListsBulkRestApiRepositoryInterface $repository
     */
    public function __construct(CompanyProductListsBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $customerReference
     * @param array<string> $uuids
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferenceAndUuids(string $customerReference, array $uuids): array
    {
        return $this->repository->getCompanyIdsByCustomerReferenceAndUuids($customerReference, $uuids);
    }

    /**
     * @param string $customerReference
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByCustomerReferenceAndGroupedIdentifier(
        string $customerReference,
        array $groupedIdentifiers
    ): array {
        if (count($groupedIdentifiers['uuid']) === 0) {
            return [];
        }

        return $this->getIdsByCustomerReferenceAndUuids($customerReference, $groupedIdentifiers['uuid']);
    }
}
