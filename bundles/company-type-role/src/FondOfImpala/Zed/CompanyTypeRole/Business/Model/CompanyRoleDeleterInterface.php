<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;

interface CompanyRoleDeleterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    public function deleteCompanyRoleAndCompanyUserByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer;
}
