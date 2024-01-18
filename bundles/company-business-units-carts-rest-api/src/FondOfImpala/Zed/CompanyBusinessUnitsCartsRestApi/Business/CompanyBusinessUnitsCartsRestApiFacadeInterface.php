<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

interface CompanyBusinessUnitsCartsRestApiFacadeInterface
{
    /**
     * Specifications:
     * - Returns a list of quotes
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findQuotes(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
    ): CompanyBusinessUnitQuoteListTransfer;
}
