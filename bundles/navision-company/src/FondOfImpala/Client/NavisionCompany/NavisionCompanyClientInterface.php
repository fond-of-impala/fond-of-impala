<?php

namespace FondOfImpala\Client\NavisionCompany;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

interface NavisionCompanyClientInterface
{
    /**
     * Specification:
     * - Finds a company by external reference.
     * - Makes zed request.
     * - Requires external reference field to be set in CompanyTransfer taken as parameter.
     *
     * @api
     *
     * {@internal will work if external reference field is provided.}
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByExternalReference(CompanyTransfer $companyTransfer): CompanyResponseTransfer;
}
