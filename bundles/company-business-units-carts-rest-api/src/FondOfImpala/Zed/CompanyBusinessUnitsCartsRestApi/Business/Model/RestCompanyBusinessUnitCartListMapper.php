<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

class RestCompanyBusinessUnitCartListMapper implements RestCompanyBusinessUnitCartListMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer
     */
    public function mapToCompanyBusinessUnitQuoteListRequestTransfer(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
    ): CompanyBusinessUnitQuoteListRequestTransfer {
        return (new CompanyBusinessUnitQuoteListRequestTransfer())
            ->fromArray($restCompanyBusinessUnitCartListTransfer->toArray(), true);
    }
}
