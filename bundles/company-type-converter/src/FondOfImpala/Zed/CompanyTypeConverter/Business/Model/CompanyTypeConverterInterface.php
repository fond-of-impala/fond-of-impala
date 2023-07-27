<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyTypeConverterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function convertCompanyType(CompanyTransfer $companyTransfer): CompanyResponseTransfer;
}
