<?php

namespace FondOfImpala\Zed\NavisionCompanyUnitAddress\Business;

use Generated\Shared\Transfer\CompanyUnitAddressResponseTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;

interface NavisionCompanyUnitAddressFacadeInterface
{
    /**
     * Specification:
     * - Finds a company unit address by external reference.
     * - Requires external reference field to be set in CompanyUnitAddressTransfer taken as parameter.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressResponseTransfer
     */
    public function findCompanyUnitAddressByExternalReference(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer
    ): CompanyUnitAddressResponseTransfer;
}
