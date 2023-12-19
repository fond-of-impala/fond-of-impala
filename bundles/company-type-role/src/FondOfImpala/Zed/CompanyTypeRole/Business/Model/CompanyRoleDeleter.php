<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;

class CompanyRoleDeleter implements CompanyRoleDeleterInterface
{
    protected CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade;

    protected CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade;

    protected CompanyTypeRoleRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface $repository
     */
    public function __construct(
        CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade,
        CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeRoleRepositoryInterface $repository
    )
    {
        $this->companyUserFacade = $companyUserFacade;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    public function deleteCompanyRoleAndCompanyUserByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer
    {
        $companyUserCollection = $this->repository->findCompanyUserIdsByCompanyRoleId($companyRoleTransfer->getIdCompanyRole());

        foreach ($companyUserCollection->getCompanyUsers() as $companyUser){
            $this->companyUserFacade->deleteCompanyUser($companyUser);
        }

        return $this->companyRoleFacade->delete($companyRoleTransfer);
    }
}
