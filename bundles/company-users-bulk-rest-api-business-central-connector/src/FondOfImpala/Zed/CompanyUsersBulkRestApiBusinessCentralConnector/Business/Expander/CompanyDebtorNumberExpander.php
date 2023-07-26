<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\Expander;

use FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence\CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;

class CompanyDebtorNumberExpander implements ExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence\CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface
     */
    protected CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence\CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface $repository
     */
    public function __construct(CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface $repository)
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
        $companyCollection = $this->repository->findCompaniesByDebtorNumbers($this->resolveDebtorNumber($companyUsersBulkPreparationCollectionTransfer));
        $companies = [];
        foreach ($companyCollection->getCompanies() as $companyTransfer) {
            $companies[$companyTransfer->getDebtorNumber()] = $companyTransfer;
        }

        foreach ($companyUsersBulkPreparationCollectionTransfer->getItems() as $preparedItem) {
            if ($preparedItem->getCompany() !== null) {
                continue;
            }

            $debtorNumber = $preparedItem->getItem()->getCompany()->getDebtorNumber();
            if (array_key_exists($debtorNumber, $companies)) {
                $preparedItem->setCompany($companies[$debtorNumber]);
            }
        }

        return $companyUsersBulkPreparationCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer
     *
     * @return array
     */
    protected function resolveDebtorNumber(CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer): array
    {
        $debtorNumbers = [];
        foreach ($companyUsersBulkPreparationTransfer->getItems() as $preparedItem) {
            if ($preparedItem->getCompany() !== null) {
                continue;
            }
            $debtorNumber = $preparedItem->getItem()->getCompany()->getDebtorNumber();
            if ($debtorNumber !== null && $debtorNumber !== '') {
                $debtorNumbers[] = $debtorNumber;
            }
        }

        return $debtorNumbers;
    }
}
