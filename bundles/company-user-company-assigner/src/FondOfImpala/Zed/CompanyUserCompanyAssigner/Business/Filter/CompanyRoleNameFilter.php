<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleNameFilter implements CompanyRoleNameFilterInterface
{
    protected CompanyUserCompanyAssignerRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $repository
     */
    public function __construct(CompanyUserCompanyAssignerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return string|null
     */
    public function filterFromCompanyUser(CompanyUserTransfer $companyUserTransfer): ?string
    {
        $companyRoleCollectionTransfer = $companyUserTransfer->getCompanyRoleCollection();

        if ($companyRoleCollectionTransfer === null || $companyRoleCollectionTransfer->getRoles()->count() !== 1) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer */
        $companyRoleTransfer = $companyRoleCollectionTransfer->getRoles()
            ->offsetGet(0);

        $companyRoleName = $companyRoleTransfer->getName();
        $idCompanyRole = $companyRoleTransfer->getIdCompanyRole();

        if ($companyRoleName === null && $idCompanyRole === null) {
            return null;
        }

        if ($companyRoleName !== null) {
            return $companyRoleName;
        }

        return $this->repository->findCompanyRoleNameByIdCompanyRole($idCompanyRole);
    }
}
