<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListBusinessFactory getFactory()
 */
class CompanyBusinessUnitPriceListFacade extends AbstractFacade implements CompanyBusinessUnitPriceListFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function expandCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitTransfer {
        return $this->getFactory()->createCompanyBusinessUnitExpander()->expand($companyBusinessUnitTransfer);
    }
}
