<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;

interface CompanyUsersBulkPostHandlingPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function postHandling(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): RestCompanyUsersBulkResponseTransfer;
}
