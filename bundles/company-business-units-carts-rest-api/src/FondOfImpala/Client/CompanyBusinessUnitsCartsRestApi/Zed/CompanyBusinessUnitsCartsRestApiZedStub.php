<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed;

use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

class CompanyBusinessUnitsCartsRestApiZedStub implements CompanyBusinessUnitsCartsRestApiZedStubInterface
{
    /**
     * @var \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findQuotes(RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer): CompanyBusinessUnitQuoteListTransfer
    {
        /** @var \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer $companyBusinessUnitOrderListTransfer */
        $companyBusinessUnitOrderListTransfer = $this->zedRequestClient->call(
            '/company-business-units-carts-rest-api/gateway/find-quotes',
            $restCompanyBusinessUnitCartListTransfer,
        );

        return $companyBusinessUnitOrderListTransfer;
    }
}
