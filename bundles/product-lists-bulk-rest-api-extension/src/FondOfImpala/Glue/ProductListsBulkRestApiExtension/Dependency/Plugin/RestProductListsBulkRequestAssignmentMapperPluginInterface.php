<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface RestProductListsBulkRequestAssignmentMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer
     */
    public function mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
        RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer,
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): RestProductListsBulkRequestAssignmentTransfer;
}
