<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Business;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface NavisionCompanyUserFacadeInterface
{
    /**
     * Specification:
     * - Finds a company user by external reference.
     * - Requires external reference field to be set in CompanyUserTransfer taken as parameter.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByUuid(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;
}
