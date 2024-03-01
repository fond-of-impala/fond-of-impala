<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter;

use ArrayObject;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

class GroupedIdentifierFilter implements GroupedIdentifierFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return array<string, array<string>>
     */
    public function filterFromRestProductListsBulkRequest(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): array {
        return $this->filterFromRestProductListsBulkRequestAssignments($restProductListsBulkRequestTransfer->getAssignments());
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer> $restProductListsBulkRequestAssignmentTransfers
     *
     * @return array<string, array<string>>
     */
    public function filterFromRestProductListsBulkRequestAssignments(
        ArrayObject $restProductListsBulkRequestAssignmentTransfers
    ): array {
        $groupedIdentifier = ['uuid' => [], 'key' => []];

        foreach ($restProductListsBulkRequestAssignmentTransfers as $restProductListsBulkRequestItemTransfer) {
            $tempGroupedIdentifier = $this->filterFromRestProductListsBulkRequestAssignmentProductLists(
                $restProductListsBulkRequestItemTransfer->getProductListsToAssign(),
            );

            $groupedIdentifier['uuid'] = array_unique(array_merge($groupedIdentifier['uuid'], $tempGroupedIdentifier['uuid']));
            $groupedIdentifier['key'] = array_unique(array_merge($groupedIdentifier['key'], $tempGroupedIdentifier['key']));

            $tempGroupedIdentifier = $this->filterFromRestProductListsBulkRequestAssignmentProductLists(
                $restProductListsBulkRequestItemTransfer->getProductListsToUnassign(),
            );

            $groupedIdentifier['uuid'] = array_unique(array_merge($groupedIdentifier['uuid'], $tempGroupedIdentifier['uuid']));
            $groupedIdentifier['key'] = array_unique(array_merge($groupedIdentifier['key'], $tempGroupedIdentifier['key']));
        }

        return $groupedIdentifier;
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer> $restProductListsBulkRequestAssignmentProductListTransfers
     *
     * @return array<string, array<string>>
     */
    public function filterFromRestProductListsBulkRequestAssignmentProductLists(
        ArrayObject $restProductListsBulkRequestAssignmentProductListTransfers
    ): array {
        $groupedIdentifier = ['uuid' => [], 'key' => []];

        foreach ($restProductListsBulkRequestAssignmentProductListTransfers as $restProductListsBulkRequestAssignmentProductListTransfer) {
            $uuid = $restProductListsBulkRequestAssignmentProductListTransfer->getUuid();
            $key = $restProductListsBulkRequestAssignmentProductListTransfer->getKey();

            if ($uuid !== null) {
                $groupedIdentifier['uuid'][] = $uuid;

                continue;
            }

            if ($key === null) {
                continue;
            }

            $groupedIdentifier['key'][] = $key;
        }

        return $groupedIdentifier;
    }
}
