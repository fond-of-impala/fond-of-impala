<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CompanyUserMapper implements CompanyUserMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        if ($restCompanyUsersRequestAttributesTransfer->getIsActive() !== null) {
            $companyUserTransfer->setIsActive(
                $restCompanyUsersRequestAttributesTransfer->getIsActive(),
            );
        }

        if ($restCompanyUsersRequestAttributesTransfer->getIsDefault() !== null) {
            $companyUserTransfer->setIsDefault(
                $restCompanyUsersRequestAttributesTransfer->getIsDefault(),
            );
        }

        return $companyUserTransfer;
    }
}
