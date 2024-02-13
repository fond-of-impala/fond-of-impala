<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;

class RestProductListsBulkRequestAssignmentProductListsMapper implements RestProductListsBulkRequestAssignmentProductListsMapperInterface
{
    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkAssignmentProductListTransfer> $restProductListsBulkAssignmentProductListTransfers
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer>
     */
    public function fromRestProductListsBulkAssignmentProductLists(
        ArrayObject $restProductListsBulkAssignmentProductListTransfers
    ): ArrayObject {
        $restProductListsBulkRequestAssignmentProductListTransfers = new ArrayObject();

        foreach ($restProductListsBulkAssignmentProductListTransfers as $restProductListsBulkAssignmentProductListTransfer) {
            $uuid = $restProductListsBulkAssignmentProductListTransfer->getId();
            $key = $restProductListsBulkAssignmentProductListTransfer->getKey();

            if ($uuid === null && $key === null) {
                continue;
            }

            $restProductListsBulkRequestAssignmentProductListTransfer = (new RestProductListsBulkRequestAssignmentProductListTransfer())
                ->setUuid($uuid)
                ->setKey($key);

            $restProductListsBulkRequestAssignmentProductListTransfers->append(
                $restProductListsBulkRequestAssignmentProductListTransfer,
            );
        }

        return $restProductListsBulkRequestAssignmentProductListTransfers;
    }
}
