<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;

interface QuoteReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findByCompanyBusinessUnitQuoteListRequest(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
    ): CompanyBusinessUnitQuoteListTransfer;
}
