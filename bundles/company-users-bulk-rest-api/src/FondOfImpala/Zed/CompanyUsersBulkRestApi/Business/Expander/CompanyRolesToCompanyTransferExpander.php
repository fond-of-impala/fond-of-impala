<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;

class CompanyRolesToCompanyTransferExpander implements ExpanderInterface
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
        $companyIds = $this->resolveCompanyIds($companyUsersBulkPreparationCollectionTransfer);
        $companyRolesCollection = $this->repository->findCompanyRolesByCompanyIds($companyIds);

        foreach ($companyUsersBulkPreparationCollectionTransfer->getItems() as $item) {
            $companyTransfer = $item->getCompany();
            if ($companyTransfer === null) {
                continue;
            }
            $idCompany = $companyTransfer->getIdCompany();
            $companyRoles = [];
            foreach ($companyTransfer->getCompanyRoles() as $companyRole) {
                $companyRoles[$companyRole->getIdCompanyRole()] = $companyRole;
            }

            if (array_key_exists($idCompany, $companyRolesCollection)) {
                foreach ($companyRolesCollection[$idCompany] as $idCompanyRole => $companyRole) {
                    if (!array_key_exists($idCompanyRole, $companyRoles)) {
                        $companyTransfer->addCompanyRole($companyRole);
                        $companyRoles[$idCompanyRole] = $companyRole;
                    }
                }
            }

            $item->setCompany($companyTransfer);
        }

        return $companyUsersBulkPreparationCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return array<int>
     */
    protected function resolveCompanyIds(CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer): array
    {
        $prepared = [];
        foreach ($companyUsersBulkPreparationCollectionTransfer->getItems() as $companyUsersBulkPreparationTransfer) {
            $companyTransfer = $companyUsersBulkPreparationTransfer->getCompany();
            if ($companyTransfer === null) {
                continue;
            }
            $prepared[] = $companyTransfer->getIdCompany();
        }

        return $prepared;
    }
}
