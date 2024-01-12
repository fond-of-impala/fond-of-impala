<?php

namespace FondOfImpala\Client\CompanyUserCartsRestApi\Zed;

use FondOfImpala\Client\CompanyUserCartsRestApi\Dependency\Client\CompanyUserCartsRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;

class CompanyUserCartsRestApiStub implements CompanyUserCartsRestApiStubInterface
{
    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\Dependency\Client\CompanyUserCartsRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CompanyUserCartsRestApi\Dependency\Client\CompanyUserCartsRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyUserCartsRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function createQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer $restCompanyUserCartsResponseTransfer */
        $restCompanyUserCartsResponseTransfer = $this->zedRequestClient->call(
            '/company-user-carts-rest-api/gateway/create-quote-by-rest-company-user-carts-request',
            $restCompanyUserCartsRequestTransfer,
        );

        return $restCompanyUserCartsResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function updateQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer $restCompanyUserCartsResponseTransfer */
        $restCompanyUserCartsResponseTransfer = $this->zedRequestClient->call(
            '/company-user-carts-rest-api/gateway/update-quote-by-rest-company-user-carts-request',
            $restCompanyUserCartsRequestTransfer,
        );

        return $restCompanyUserCartsResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function deleteQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer $restCompanyUserCartsResponseTransfer */
        $restCompanyUserCartsResponseTransfer = $this->zedRequestClient->call(
            '/company-user-carts-rest-api/gateway/delete-quote-by-rest-company-user-carts-request',
            $restCompanyUserCartsRequestTransfer,
        );

        return $restCompanyUserCartsResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function findQuoteByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer $restCompanyUserCartsResponseTransfer */
        $restCompanyUserCartsResponseTransfer = $this->zedRequestClient->call(
            '/company-user-carts-rest-api/gateway/find-quote-by-rest-company-user-carts-request',
            $restCompanyUserCartsRequestTransfer,
        );

        return $restCompanyUserCartsResponseTransfer;
    }
}
