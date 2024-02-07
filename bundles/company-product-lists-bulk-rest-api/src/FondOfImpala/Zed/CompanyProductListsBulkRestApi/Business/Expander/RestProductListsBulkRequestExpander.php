<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\CompanyReaderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

class RestProductListsBulkRequestExpander implements RestProductListsBulkRequestExpanderInterface
{
    protected GroupedIdentifierFilterInterface $groupedIdentifierFilter;

    protected CompanyReaderInterface $companyReader;

    /**
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface $groupedIdentifierFilter
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\CompanyReaderInterface $companyReader
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

        $companyIds = $this->companyReader->getIdsByGroupedIdentifier($groupedIdentifier);

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

            $uuid = $restProductListsBulkRequestItemCompanyTransfer->getUuid();

            if ($uuid !== null && isset($companyIds[$uuid])) {
                $restProductListsBulkRequestItemCompanyTransfer->setId($companyIds[$uuid]);

                continue;
            }

            $debtorNumber = $restProductListsBulkRequestItemCompanyTransfer->getDebtorNumber();

            if ($debtorNumber === null || !isset($companyIds[$debtorNumber])) {
                continue;
            }

            $restProductListsBulkRequestItemCompanyTransfer->setId($companyIds[$debtorNumber]);
        }

        return $restProductListsBulkRequestAssignmentTransfers;
    }
}
