<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserQuoteToCompanyUserReferenceFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;
}
