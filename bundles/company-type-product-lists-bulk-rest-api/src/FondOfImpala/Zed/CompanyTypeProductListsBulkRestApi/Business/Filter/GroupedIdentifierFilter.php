<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Filter;

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
        $groupedIdentifier = ['customerReference' => [], 'email' => []];

        foreach ($restProductListsBulkRequestAssignmentTransfers as $restProductListsBulkRequestItemTransfer) {
            $restProductListsBulkRequestAssignmentCustomerTransfer = $restProductListsBulkRequestItemTransfer->getCustomer();

            if ($restProductListsBulkRequestAssignmentCustomerTransfer === null) {
                continue;
            }

            $customerReference = $restProductListsBulkRequestAssignmentCustomerTransfer->getCustomerReference();
            $email = $restProductListsBulkRequestAssignmentCustomerTransfer->getEmail();

            if ($customerReference !== null) {
                $groupedIdentifier['customerReference'][] = $customerReference;

                continue;
            }

            if ($email === null) {
                continue;
            }

            $groupedIdentifier['email'][] = $email;
        }

        return $groupedIdentifier;
    }
}
