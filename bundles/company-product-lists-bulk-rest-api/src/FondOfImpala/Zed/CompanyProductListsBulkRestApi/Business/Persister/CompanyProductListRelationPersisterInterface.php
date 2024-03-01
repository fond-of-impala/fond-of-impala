<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Persister;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface CompanyProductListRelationPersisterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return void
     */
    public function persist(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): void;
}
