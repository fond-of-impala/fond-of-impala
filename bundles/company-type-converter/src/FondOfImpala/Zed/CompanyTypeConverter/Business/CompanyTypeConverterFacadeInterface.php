<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyTypeConverterFacadeInterface
{
    /**
     * Specification:
     *  - Converts company type
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function convertCompanyType(CompanyTransfer $companyTransfer): CompanyResponseTransfer;

    /**
     * Specification:
     *  - Retrieve a company by CompanyTransfer::idCompany in the transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function findCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferFrom
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferTo
     *
     * @return bool
     */
    public function isTypeConvertable(CompanyTransfer $companyTransferFrom, CompanyTransfer $companyTransferTo): bool;
}
