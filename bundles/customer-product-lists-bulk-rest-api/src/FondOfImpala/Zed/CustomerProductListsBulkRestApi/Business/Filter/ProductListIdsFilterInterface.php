<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter;

use ArrayObject;

interface ProductListIdsFilterInterface
{
    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer> $restProductListsBulkRequestAssignmentProductListTransfers
     *
     * @return array<int>
     */
    public function filterFromRestProductListsBulkRequestAssignmentProductLists(
        ArrayObject $restProductListsBulkRequestAssignmentProductListTransfers
    ): array;
}
