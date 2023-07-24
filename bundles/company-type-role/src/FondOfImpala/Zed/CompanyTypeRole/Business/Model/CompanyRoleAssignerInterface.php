<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use Generated\Shared\Transfer\CompanyResponseTransfer;

interface CompanyRoleAssignerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignPredefinedCompanyRolesToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer;
}
