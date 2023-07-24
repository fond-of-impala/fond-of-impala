<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyTypeConverterToCompanyFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function getCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer;
}
