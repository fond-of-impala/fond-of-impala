<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter;

use ArrayObject;

class ProductListIdsFilter implements ProductListIdsFilterInterface
{
    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer> $restProductListsBulkRequestAssignmentProductListTransfers
     *
     * @return array<int>
     */
    public function filterFromRestProductListsBulkRequestAssignmentProductLists(
        ArrayObject $restProductListsBulkRequestAssignmentProductListTransfers
    ): array {
        $productListIds = [];

        foreach ($restProductListsBulkRequestAssignmentProductListTransfers as $restProductListsBulkRequestAssignmentProductListTransfer) {
            $productListId = $restProductListsBulkRequestAssignmentProductListTransfer->getId();

            if ($productListId === null) {
                continue;
            }

            $productListIds[] = $productListId;
        }

        return $productListIds;
    }
}
