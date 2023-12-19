<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyRoleManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function updateCompanyRolesOfNonManufacturerUsers(
        CompanyUserTransfer $companyUserTransfer
    ): void;
}
