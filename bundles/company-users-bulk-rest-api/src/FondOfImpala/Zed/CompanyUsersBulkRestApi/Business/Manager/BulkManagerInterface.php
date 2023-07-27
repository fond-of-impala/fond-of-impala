<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager;

use Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;

interface BulkManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function handleBulkRequest(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): RestCompanyUsersBulkResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
     *
     * @return void
     */
    public function createCompanyUser(RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUser(RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer): void;
}
