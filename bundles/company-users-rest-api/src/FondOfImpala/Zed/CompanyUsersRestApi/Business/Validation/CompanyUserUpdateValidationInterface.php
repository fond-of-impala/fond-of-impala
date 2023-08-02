<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation;

use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

interface CompanyUserUpdateValidationInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     * @return bool
     */
    public function validate(
        CompanyUserTransfer                  $companyUserTransfer,
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): bool;
}
