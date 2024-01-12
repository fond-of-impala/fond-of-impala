<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

interface WritePermissionCheckerInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return bool
     */
    public function checkByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): bool;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    public function checkByCompanyUser(
        CompanyUserTransfer $companyUserTransfer
    ): bool;

    /**
     * @param int $idCompanyUser
     *
     * @return bool
     */
    public function checkByIdCompanyUser(int $idCompanyUser): bool;
}
