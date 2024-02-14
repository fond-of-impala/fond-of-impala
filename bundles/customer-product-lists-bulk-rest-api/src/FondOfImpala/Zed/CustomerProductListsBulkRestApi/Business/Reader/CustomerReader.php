<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence\CustomerProductListsBulkRestApiRepositoryInterface;

class CustomerReader implements CustomerReaderInterface
{
    protected CustomerProductListsBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence\CustomerProductListsBulkRestApiRepositoryInterface $repository
     */
    public function __construct(CustomerProductListsBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array<string> $customerReferences
     *
     * @return array<string, int>
     */
    public function getIdsByCustomerReferences(array $customerReferences): array
    {
        return $this->repository->getCustomerIdsByCustomerReferences($customerReferences);
    }

    /**
     * @param array<string> $emails
     *
     * @return array<string, int>
     */
    public function getIdsByEmails(array $emails): array
    {
        return $this->repository->getCustomerIdsByEmails($emails);
    }

    /**
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByGroupedIdentifier(array $groupedIdentifiers): array
    {
        $customerIds = [];

        if (count($groupedIdentifiers['customerReference']) > 0) {
            $customerIds += $this->getIdsByCustomerReferences($groupedIdentifiers['customerReference']);
        }

        if (count($groupedIdentifiers['email']) === 0) {
            return $customerIds;
        }

        return $customerIds + $this->getIdsByEmails($groupedIdentifiers['email']);
    }
}
