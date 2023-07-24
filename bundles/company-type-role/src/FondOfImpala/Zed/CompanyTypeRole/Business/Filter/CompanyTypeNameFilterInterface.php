<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Filter;

use Generated\Shared\Transfer\CompanyRoleTransfer;

interface CompanyTypeNameFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return string|null
     */
    public function filterFromCompanyRole(CompanyRoleTransfer $companyRoleTransfer): ?string;
}
