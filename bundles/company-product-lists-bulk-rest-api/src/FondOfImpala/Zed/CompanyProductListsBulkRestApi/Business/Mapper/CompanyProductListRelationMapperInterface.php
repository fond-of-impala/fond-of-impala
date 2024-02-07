<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper;

use Generated\Shared\Transfer\CompanyProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface CompanyProductListRelationMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyProductListRelationTransfer|null
     */
    public function fromRestProductListsBulkRequestAssignmentTransfer(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): ?CompanyProductListRelationTransfer;
}
