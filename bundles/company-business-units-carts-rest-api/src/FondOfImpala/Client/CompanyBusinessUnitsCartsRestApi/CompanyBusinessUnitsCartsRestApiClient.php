<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiFactory getFactory()
 */
class CompanyBusinessUnitsCartsRestApiClient extends AbstractClient implements CompanyBusinessUnitsCartsRestApiClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findQuotes(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
    ): CompanyBusinessUnitQuoteListTransfer {
        return $this->getFactory()
            ->createCompanyBusinessUnitsCartsRestApiZedStub()
            ->findQuotes($restCompanyBusinessUnitCartListTransfer);
    }
}
