<?php

namespace FondOfImpala\Client\CompanyUsersBulkRestApi;

use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiFactory getFactory()
 */
class CompanyUsersBulkRestApiClient extends AbstractClient implements CompanyUsersBulkRestApiClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function bulkProcess(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): RestCompanyUsersBulkResponseTransfer {
        return $this->getFactory()->createZedCompanyUsersBulkRestApiStub()->bulkProcess($restCompanyUsersBulkRequestTransfer);
    }
}
