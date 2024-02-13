<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\CustomerReaderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

class RestProductListsBulkRequestExpander implements RestProductListsBulkRequestExpanderInterface
{
    protected GroupedIdentifierFilterInterface $groupedIdentifierFilter;

    protected CustomerReaderInterface $customerReader;

    /**
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface $groupedIdentifierFilter
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\CustomerReaderInterface $customerReader
     */
    public function __construct(
        GroupedIdentifierFilterInterface $groupedIdentifierFilter,
        CustomerReaderInterface $customerReader
    ) {
        $this->groupedIdentifierFilter = $groupedIdentifierFilter;
        $this->customerReader = $customerReader;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function expand(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkRequestTransfer {
        $groupedIdentifier = $this->groupedIdentifierFilter->filterFromRestProductListsBulkRequest(
            $restProductListsBulkRequestTransfer,
        );

        $customerIds = $this->customerReader->getIdsByGroupedIdentifier($groupedIdentifier);

        $restProductListsBulkRequestAssignmentTransfers = $this->expandRestProductListsBulkRequestAssignments(
            $restProductListsBulkRequestTransfer->getAssignments(),
            $customerIds,
        );

        return $restProductListsBulkRequestTransfer->setAssignments($restProductListsBulkRequestAssignmentTransfers);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer> $restProductListsBulkRequestAssignmentTransfers
     * @param array<string, int> $customerIds
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer>
     */
    protected function expandRestProductListsBulkRequestAssignments(
        ArrayObject $restProductListsBulkRequestAssignmentTransfers,
        array $customerIds
    ): ArrayObject {
        foreach ($restProductListsBulkRequestAssignmentTransfers as $restProductListsBulkRequestItemTransfer) {
            $restProductListsBulkRequestItemCustomerTransfer = $restProductListsBulkRequestItemTransfer->getCustomer();

            if ($restProductListsBulkRequestItemCustomerTransfer === null) {
                continue;
            }

            $customerReference = $restProductListsBulkRequestItemCustomerTransfer->getCustomerReference();

            if ($customerReference !== null && isset($customerIds[$customerReference])) {
                $restProductListsBulkRequestItemCustomerTransfer->setId($customerIds[$customerReference]);

                continue;
            }

            $email = $restProductListsBulkRequestItemCustomerTransfer->getEmail();
            if ($email === null) {
                continue;
            }

            if (!isset($customerIds[$email])) {
                continue;
            }

            $restProductListsBulkRequestItemCustomerTransfer->setId($customerIds[$email]);
        }

        return $restProductListsBulkRequestAssignmentTransfers;
    }
}
