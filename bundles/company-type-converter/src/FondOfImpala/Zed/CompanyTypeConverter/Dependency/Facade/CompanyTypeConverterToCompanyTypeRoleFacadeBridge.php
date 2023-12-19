<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeConverterToCompanyTypeRoleFacadeBridge implements CompanyTypeConverterToCompanyTypeRoleFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface
     */
    protected $companyTypeRoleFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface $companyTypeRoleFacade
     */
    public function __construct(CompanyTypeRoleFacadeInterface $companyTypeRoleFacade)
    {
        $this->companyTypeRoleFacade = $companyTypeRoleFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return array
     */
    public function getPermissionKeysByCompanyTypeAndCompanyRole(
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): array {
        return $this->companyTypeRoleFacade
            ->getPermissionKeysByCompanyTypeAndCompanyRole($companyTypeTransfer, $companyRoleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    public function deleteCompanyRoleAndCompanyUserByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer
    {
        return $this->companyTypeRoleFacade->deleteCompanyRoleAndCompanyUserByCompanyRole($companyRoleTransfer);
    }
}
