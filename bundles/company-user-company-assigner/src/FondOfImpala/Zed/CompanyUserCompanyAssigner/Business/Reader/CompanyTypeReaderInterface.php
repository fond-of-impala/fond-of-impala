<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getManufacturerCompanyType(): CompanyTypeTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getByCompany(CompanyTransfer $companyTransfer): CompanyTypeTransfer;
}
