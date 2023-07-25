<?php

namespace FondOfImpala\Client\CompanyType\Zed;

use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(
        CompanyTypeTransfer $companyTypeTransfer
    ): CompanyTypeResponseTransfer;
}
