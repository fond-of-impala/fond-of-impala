<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyRoleNameFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return string|null
     */
    public function filterFromCompanyUser(CompanyUserTransfer $companyUserTransfer): ?string;
}
