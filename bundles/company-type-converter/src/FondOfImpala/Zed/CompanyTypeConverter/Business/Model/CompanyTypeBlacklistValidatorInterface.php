<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeBlacklistValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferFrom
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferTo
     * @return bool
     */
    public function validate(CompanyTransfer $companyTransferFrom, CompanyTransfer $companyTransferTo): bool;
}
