<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class CompanyUserCompanyAssignerToCompanyRoleFacadeBridge implements CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
{
    protected CompanyRoleFacadeInterface $companyRoleFacade;

    /**
     * @param \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(CompanyRoleFacadeInterface $companyRoleFacade)
    {
        $this->companyRoleFacade = $companyRoleFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function getCompanyRoleById(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleTransfer
    {
        return $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function saveCompanyUser(CompanyUserTransfer $companyUserTransfer): void
    {
        $this->companyRoleFacade->saveCompanyUser($companyUserTransfer);
    }
}
