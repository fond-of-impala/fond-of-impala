<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Generator;

use Generated\Shared\Transfer\CompanyRoleTransfer;

interface AssignPermissionKeyGeneratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return string|null
     */
    public function generateByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): ?string;
}
