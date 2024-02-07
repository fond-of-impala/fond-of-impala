<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

interface GroupedIdentifierFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return array<string, array<string>>
     */
    public function filterFromRestProductListsBulkRequest(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): array;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer> $restProductListsBulkRequestAssignmentTransfers
     *
     * @return array<string, array<string>>
     */
    public function filterFromRestProductListsBulkRequestAssignments(
        ArrayObject $restProductListsBulkRequestAssignmentTransfers
    ): array;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer> $restProductListsBulkRequestAssignmentProductListTransfers
     *
     * @return array<string, array<string>>
     */
    public function filterFromRestProductListsBulkRequestAssignmentProductLists(
        ArrayObject $restProductListsBulkRequestAssignmentProductListTransfers
    ): array;
}
