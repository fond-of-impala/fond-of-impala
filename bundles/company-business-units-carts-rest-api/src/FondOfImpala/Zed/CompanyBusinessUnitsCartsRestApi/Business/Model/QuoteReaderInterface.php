<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

interface QuoteReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function find(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
    ): CompanyBusinessUnitQuoteListTransfer;
}
