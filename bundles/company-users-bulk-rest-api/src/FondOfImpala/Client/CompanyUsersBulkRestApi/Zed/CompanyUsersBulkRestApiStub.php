<?php

namespace FondOfImpala\Client\CompanyUsersBulkRestApi\Zed;

use FondOfImpala\Client\CompanyUsersBulkRestApi\Dependency\Client\CompanyUsersBulkRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;

class CompanyUsersBulkRestApiStub implements CompanyUsersBulkRestApiStubInterface
{
    /**
     * @var string
     */
    public const BULK_PROCESS = '/company-users-bulk-rest-api/gateway/bulk-process';

    protected CompanyUsersBulkRestApiToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CompanyUsersBulkRestApi\Dependency\Client\CompanyUsersBulkRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyUsersBulkRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function bulkProcess(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): RestCompanyUsersBulkResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer $restCompanyUsersBulkResponseTransfer */
        $restCompanyUsersBulkResponseTransfer = $this
            ->zedRequestClient->call(
                static::BULK_PROCESS,
                $restCompanyUsersBulkRequestTransfer,
            );

        return $restCompanyUsersBulkResponseTransfer;
    }
}
