<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker;

use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

interface ReadPermissionCheckerInterface
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
     * @param int $idCompanyUser
     *
     * @return bool
     */
    public function checkByIdCompanyUser(int $idCompanyUser): bool;
}
