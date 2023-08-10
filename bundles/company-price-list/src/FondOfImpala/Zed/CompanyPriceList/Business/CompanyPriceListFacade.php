<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListBusinessFactory getFactory()
 */
class CompanyPriceListFacade extends AbstractFacade implements CompanyPriceListFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function hydrateCompany(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->getFactory()->createCompanyHydrator()->hydrate($companyTransfer);
    }
}
