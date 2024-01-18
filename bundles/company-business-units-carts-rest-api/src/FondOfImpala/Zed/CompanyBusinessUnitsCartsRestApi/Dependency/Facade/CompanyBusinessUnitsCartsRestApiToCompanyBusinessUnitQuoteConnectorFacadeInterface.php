<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;

interface CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findQuotes(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
    ): CompanyBusinessUnitQuoteListTransfer;
}
