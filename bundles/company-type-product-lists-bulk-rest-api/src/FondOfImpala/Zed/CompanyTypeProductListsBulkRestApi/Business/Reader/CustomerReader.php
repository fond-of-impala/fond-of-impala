<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence\CompanyTypeProductListsBulkRestApiRepositoryInterface;

class CustomerReader implements CustomerReaderInterface
{
    protected CompanyTypeProductListsBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence\CompanyTypeProductListsBulkRestApiRepositoryInterface $repository
     */
    public function __construct(CompanyTypeProductListsBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $customerReference
     * @param array<string> $colleagueReferences
     *
     * @return array<string, int>
     */
    public function getIdsByCustomerReferenceAndColleagueReferences(
        string $customerReference,
        array $colleagueReferences
    ): array {
        return $this->repository->getColleagueIdsByCustomerReferenceAndColleagueReferences(
            $customerReference,
            $colleagueReferences,
        );
    }

    /**
     * @param string $customerReference
     * @param array<string> $colleagueEmails
     *
     * @return array<int>
     */
    public function getIdsByCustomerReferenceAndColleagueEmails(
        string $customerReference,
        array $colleagueEmails
    ): array {
        return $this->repository->getColleagueIdsByCustomerReferenceAndColleagueEmails(
            $customerReference,
            $colleagueEmails,
        );
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
        $customerIds = [];

        if (count($groupedIdentifiers['customerReference']) > 0) {
            $customerIds += $this->getIdsByCustomerReferenceAndColleagueReferences(
                $customerReference,
                $groupedIdentifiers['customerReference'],
            );
        }

        if (count($groupedIdentifiers['email']) === 0) {
            return $customerIds;
        }

        return $customerIds + $this->getIdsByCustomerReferenceAndColleagueEmails(
            $customerReference,
            $groupedIdentifiers['email'],
        );
    }
}
