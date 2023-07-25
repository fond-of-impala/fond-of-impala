<?php

namespace FondOfImpala\Zed\CompanyType\Business\Model;

use Generated\Shared\Transfer\CompanyResponseTransfer;

interface CompanyTypeAssignerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignDefaultCompanyTypeToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer;
}
