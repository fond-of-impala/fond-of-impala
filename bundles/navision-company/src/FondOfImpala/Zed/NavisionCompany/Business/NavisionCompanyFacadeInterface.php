<?php

namespace FondOfImpala\Zed\NavisionCompany\Business;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

interface NavisionCompanyFacadeInterface
{
    /**
     * Specification:
     * - Finds a company by external reference.
     * - Requires external reference field to be set in CompanyTransfer taken as parameter.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByExternalReference(CompanyTransfer $companyTransfer): CompanyResponseTransfer;

    /**
     * Specification:
     * - Finds a company by debtor number.
     * - Requires debtor number field to be set in CompanyTransfer taken as parameter.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByDebtorNumber(CompanyTransfer $companyTransfer): CompanyResponseTransfer;
}
