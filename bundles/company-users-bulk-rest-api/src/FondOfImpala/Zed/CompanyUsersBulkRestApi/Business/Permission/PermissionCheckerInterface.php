<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission;

use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;

interface PermissionCheckerInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return bool
     */
    public function check(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): bool;
}
