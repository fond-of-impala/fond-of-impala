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
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getIdsByUuids(array $uuids): array
    {
        return $this->repository->getCompanyIdsByUuids($uuids);
    }

    /**
     * @param array<string> $debtorNumbers
     *
     * * @return array<string, int>
     */
    public function getIdsByDebtorNumbers(array $debtorNumbers): array
    {
        return $this->repository->getCompanyIdsByDebtorNumbers($debtorNumbers);
    }

    /**
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByGroupedIdentifier(array $groupedIdentifiers): array
    {
        $companyIds = [];

        if (count($groupedIdentifiers['uuid']) > 0) {
            $companyIds = array_merge($companyIds, $this->getIdsByUuids($groupedIdentifiers['uuid']));
        }

        if (count($groupedIdentifiers['debtorNumber']) === 0) {
            return $companyIds;
        }

        return array_merge($companyIds, $this->getIdsByDebtorNumbers($groupedIdentifiers['debtorNumber']));
    }
}
