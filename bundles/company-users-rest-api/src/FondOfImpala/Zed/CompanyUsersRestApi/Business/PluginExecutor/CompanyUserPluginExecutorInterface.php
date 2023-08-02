<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

interface CompanyUserPluginExecutorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function executePostCreatePlugins(
        CompanyUserTransfer $companyUserTransfer,
        RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
    ): CompanyUserTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function executePreCreatePlugins(
        CompanyUserTransfer $companyUserTransfer,
        RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
    ): CompanyUserTransfer;
}
