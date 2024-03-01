<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use ArrayObject;

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
