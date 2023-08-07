<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;

interface CompanyUserDeleteValidationInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return bool
     */
    public function validate(
        CompanyUserTransfer $companyUserTransfer,
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): bool;
}
