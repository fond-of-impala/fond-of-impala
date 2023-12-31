<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeConverterToCompanyTypeRoleFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return array<string>
     */
    public function getPermissionKeysByCompanyTypeAndCompanyRole(
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): array;

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    public function deleteCompanyRoleAndCompanyUserByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer;
}
