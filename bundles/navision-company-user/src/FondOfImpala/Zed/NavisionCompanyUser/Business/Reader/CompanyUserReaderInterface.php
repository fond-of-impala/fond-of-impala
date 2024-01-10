<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Business\Reader;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByExternalReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;
}
