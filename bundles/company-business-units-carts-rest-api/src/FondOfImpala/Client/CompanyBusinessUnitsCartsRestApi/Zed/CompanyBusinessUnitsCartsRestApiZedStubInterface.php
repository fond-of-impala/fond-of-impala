<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

interface CompanyBusinessUnitsCartsRestApiZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findQuotes(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
    ): CompanyBusinessUnitQuoteListTransfer;
}
