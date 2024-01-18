<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\CompanyBusinessUnitsCartsRestApiBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence\CompanyBusinessUnitsCartsRestApiRepositoryInterface getRepository()
 */
class CompanyBusinessUnitsCartsRestApiFacade extends AbstractFacade implements CompanyBusinessUnitsCartsRestApiFacadeInterface
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
    public function findQuotes(RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer): CompanyBusinessUnitQuoteListTransfer
    {
        return $this->getFactory()
            ->createQuoteReader()
            ->find($restCompanyBusinessUnitCartListTransfer);
    }
}
