<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper;

use Generated\Shared\Transfer\CustomerProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface CustomerProductListRelationMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerProductListRelationTransfer|null
     */
    public function fromRestProductListsBulkRequestAssignmentTransfer(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): ?CustomerProductListRelationTransfer;
}
