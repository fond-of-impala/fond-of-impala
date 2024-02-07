<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface RestProductListsBulkRequestAssignmentMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer
     */
    public function fromRestProductListsBulkAssignment(
        RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer
    ): RestProductListsBulkRequestAssignmentTransfer;
}
