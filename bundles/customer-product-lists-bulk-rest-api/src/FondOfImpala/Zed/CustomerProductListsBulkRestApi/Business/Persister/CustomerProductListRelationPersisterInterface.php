<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface CustomerProductListRelationPersisterInterface
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
