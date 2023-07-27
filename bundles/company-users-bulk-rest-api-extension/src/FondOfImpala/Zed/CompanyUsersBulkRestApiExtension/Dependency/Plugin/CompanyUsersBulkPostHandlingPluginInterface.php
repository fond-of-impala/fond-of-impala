<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;

interface CompanyUsersBulkPostHandlingPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer $restCompanyUsersBulkResponseTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function postHandling(
        RestCompanyUsersBulkResponseTransfer $restCompanyUsersBulkResponseTransfer
    ): RestCompanyUsersBulkResponseTransfer;
}
