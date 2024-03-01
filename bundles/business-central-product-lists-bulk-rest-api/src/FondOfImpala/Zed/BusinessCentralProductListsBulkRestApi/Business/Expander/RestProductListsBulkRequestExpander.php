<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader\CompanyReaderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

class RestProductListsBulkRequestExpander implements RestProductListsBulkRequestExpanderInterface
{
    protected GroupedIdentifierFilterInterface $groupedIdentifierFilter;

    protected CompanyReaderInterface $companyReader;

    /**
     * @param \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface $groupedIdentifierFilter
     * @param \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader\CompanyReaderInterface $companyReader
     */
    public function __construct(
        GroupedIdentifierFilterInterface $groupedIdentifierFilter,
        CompanyReaderInterface $companyReader
    ) {
        $this->groupedIdentifierFilter = $groupedIdentifierFilter;
        $this->companyReader = $companyReader;
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

        $companyIds = [];
        $customerReference = $restProductListsBulkRequestTransfer->getCustomerReference();

        if ($customerReference !== null) {
            $companyIds = $this->companyReader->getIdsByCustomerReferenceAndGroupedIdentifier(
                $customerReference,
                $groupedIdentifier,
            );
        }

        $restProductListsBulkRequestAssignmentTransfers = $this->expandRestProductListsBulkRequestAssignments(
            $restProductListsBulkRequestTransfer->getAssignments(),
            $companyIds,
        );

        return $restProductListsBulkRequestTransfer->setAssignments($restProductListsBulkRequestAssignmentTransfers);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer> $restProductListsBulkRequestAssignmentTransfers
     * @param array<string, int> $companyIds
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer>
     */
    protected function expandRestProductListsBulkRequestAssignments(
        ArrayObject $restProductListsBulkRequestAssignmentTransfers,
        array $companyIds
    ): ArrayObject {
        foreach ($restProductListsBulkRequestAssignmentTransfers as $restProductListsBulkRequestItemTransfer) {
            $restProductListsBulkRequestItemCompanyTransfer = $restProductListsBulkRequestItemTransfer->getCompany();

            if ($restProductListsBulkRequestItemCompanyTransfer === null) {
                continue;
            }

            $debtorNumber = $restProductListsBulkRequestItemCompanyTransfer->getDebtorNumber();

            if ($debtorNumber === null) {
                continue;
            }

            if (!isset($companyIds[$debtorNumber])) {
                continue;
            }

            $restProductListsBulkRequestItemCompanyTransfer->setId($companyIds[$debtorNumber]);
        }

        return $restProductListsBulkRequestAssignmentTransfers;
    }
}
