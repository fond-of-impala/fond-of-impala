<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

class RestProductListsBulkRequestMapper implements RestProductListsBulkRequestMapperInterface
{
    protected RestProductListsBulkRequestAssignmentMapperInterface $restProductListsBulkRequestAssignmentMapper;

    /**
     * @param \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentMapperInterface $restProductListsBulkRequestAssignmentMapper
     */
    public function __construct(
        RestProductListsBulkRequestAssignmentMapperInterface $restProductListsBulkRequestAssignmentMapper
    ) {
        $this->restProductListsBulkRequestAssignmentMapper = $restProductListsBulkRequestAssignmentMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function fromRestProductListsBulkRequestAttributes(
        RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
    ): RestProductListsBulkRequestTransfer {
        $restProductListsBulkRequestTransfer = (new RestProductListsBulkRequestTransfer());
        $restProductListsBulkAssignmentTransfers = $restProductListsBulkRequestAttributesTransfer->getAssignments();

        foreach ($restProductListsBulkAssignmentTransfers as $restProductListsBulkAssignmentTransfer) {
            $restProductListsBulkRequestAssignmentTransfer = $this->restProductListsBulkRequestAssignmentMapper->fromRestProductListsBulkAssignment(
                $restProductListsBulkAssignmentTransfer,
            );

            $restProductListsBulkRequestTransfer->addAssignment($restProductListsBulkRequestAssignmentTransfer);
        }

        return $restProductListsBulkRequestTransfer;
    }
}
