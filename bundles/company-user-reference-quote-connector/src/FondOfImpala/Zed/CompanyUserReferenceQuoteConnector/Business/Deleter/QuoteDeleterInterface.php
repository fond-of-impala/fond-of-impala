<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface QuoteDeleterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function deleteByCompanyUser(CompanyUserTransfer $companyUserTransfer): void;
}
