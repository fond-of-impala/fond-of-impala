<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;

class CompanyExpander implements ExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface
     */
    protected CompanyUsersBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface $repository
     */
    public function __construct(CompanyUsersBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expand(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        $companyCollection = $this->repository->findCompaniesByUuids($this->resolveCompanyIds($companyUsersBulkPreparationCollectionTransfer));
        $companies = [];
        foreach ($companyCollection->getCompanies() as $companyTransfer) {
            $companies[$companyTransfer->getUuid()] = $companyTransfer;
        }

        foreach ($companyUsersBulkPreparationCollectionTransfer->getItems() as $preparedItem) {
            if ($preparedItem->getCompany() !== null) {
                continue;
            }

            $companyId = $preparedItem->getItem()->getCompany()->getCompanyId();
            if (array_key_exists($companyId, $companies)) {
                $preparedItem->setCompany($companies[$companyId]);
            }
        }

        return $companyUsersBulkPreparationCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer
     *
     * @return array
     */
    protected function resolveCompanyIds(CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer): array
    {
        $companyIds = [];
        foreach ($companyUsersBulkPreparationTransfer->getItems() as $preparedItem) {
            if ($preparedItem->getCompany() !== null) {
                continue;
            }
            $companyId = $preparedItem->getItem()->getCompany()->getCompanyId();
            if ($companyId !== null && $companyId !== '') {
                $companyIds[] = $companyId;
            }
        }

        return $companyIds;
    }
}
