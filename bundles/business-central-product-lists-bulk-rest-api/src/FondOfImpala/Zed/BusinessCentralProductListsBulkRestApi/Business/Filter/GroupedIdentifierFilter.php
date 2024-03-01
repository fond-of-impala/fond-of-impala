<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Filter;

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
        $groupedIdentifier = ['debtorNumber' => []];

        foreach ($restProductListsBulkRequestAssignmentTransfers as $restProductListsBulkRequestItemTransfer) {
            $restProductListsBulkRequestAssignmentCompanyTransfer = $restProductListsBulkRequestItemTransfer->getCompany();

            if ($restProductListsBulkRequestAssignmentCompanyTransfer === null) {
                continue;
            }

            $debtorNumber = $restProductListsBulkRequestAssignmentCompanyTransfer->getDebtorNumber();

            if ($debtorNumber === null) {
                continue;
            }

            $groupedIdentifier['debtorNumber'][] = $debtorNumber;
        }

        return $groupedIdentifier;
    }
}
