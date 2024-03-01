<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence\BusinessCentralProductListsBulkRestApiRepositoryInterface;

class CompanyReader implements CompanyReaderInterface
{
    protected BusinessCentralProductListsBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence\BusinessCentralProductListsBulkRestApiRepositoryInterface $repository
     */
    public function __construct(BusinessCentralProductListsBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $customerReference
     * @param array<string> $debtorNumbers
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferenceAndDebtorNumbers(string $customerReference, array $debtorNumbers): array
    {
        return $this->repository->getCompanyIdsByCustomerReferenceAndDebtorNumbers($customerReference, $debtorNumbers);
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
        $companyIds = [];

        if (count($groupedIdentifiers['debtorNumber']) === 0) {
            return $companyIds;
        }

        return $companyIds + $this->getIdsByCustomerReferenceAndDebtorNumbers(
            $customerReference,
            $groupedIdentifiers['debtorNumber'],
        );
    }
}
