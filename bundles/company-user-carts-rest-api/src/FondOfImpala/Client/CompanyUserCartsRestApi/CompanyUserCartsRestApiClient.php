<?php

namespace FondOfImpala\Client\CompanyUserCartsRestApi;

use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiFactory getFactory()
 */
class CompanyUserCartsRestApiClient extends AbstractClient implements CompanyUserCartsRestApiClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function updateQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        return $this->getFactory()
            ->createCompanyUserCartsRestApiStub()
            ->updateQuoteByRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function createQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        return $this->getFactory()
            ->createCompanyUserCartsRestApiStub()
            ->createQuoteByRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function deleteQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        return $this->getFactory()
            ->createCompanyUserCartsRestApiStub()
            ->deleteQuoteByRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function findQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        return $this->getFactory()
            ->createCompanyUserCartsRestApiStub()
            ->findQuoteByRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer);
    }
}
