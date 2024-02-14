<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface RestProductListsBulkRequestAssignmentCheckerInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return bool
     */
    public function preCheck(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): bool;
}
