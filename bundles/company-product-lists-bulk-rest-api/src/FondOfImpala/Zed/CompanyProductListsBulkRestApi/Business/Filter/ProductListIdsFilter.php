<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

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
            $productListId = $restProductListsBulkRequestAssignmentProductListTransfer->getIdProductList();

            if ($productListId === null) {
                continue;
            }

            $productListIds[] = $productListId;
        }

        return $productListIds;
    }
}
