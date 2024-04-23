<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyTypeBlacklistValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferFrom
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferTo
     *
     * @return bool
     */
    public function validate(CompanyTransfer $companyTransferFrom, CompanyTransfer $companyTransferTo): bool;
}
