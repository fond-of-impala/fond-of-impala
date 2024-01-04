<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface NavisionCompanyBusinessUnitFacadeInterface
{
    /**
     * Specification:
     * - Finds a company business unit by external reference.
     * - Requires external reference field to be set in CompanyBusinessUnitTransfer taken as parameter.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    public function findCompanyBusinessUnitByUuid(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitResponseTransfer;
}
