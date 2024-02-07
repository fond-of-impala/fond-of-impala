<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;


interface RestProductListsBulkRequestAssignmentProductListsMapperInterface
{
    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkAssignmentProductListTransfer> $restProductListsBulkAssignmentProductListTransfers
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer>
     */
    public function fromRestProductListsBulkAssignmentProductLists(
        ArrayObject $restProductListsBulkAssignmentProductListTransfers
    ): ArrayObject;
}
