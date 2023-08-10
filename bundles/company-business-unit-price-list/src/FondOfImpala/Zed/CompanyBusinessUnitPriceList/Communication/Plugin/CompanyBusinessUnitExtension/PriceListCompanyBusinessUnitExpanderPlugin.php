<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Communication\Plugin\CompanyBusinessUnitExtension;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListFacadeInterface getFacade()
 */
class PriceListCompanyBusinessUnitExpanderPlugin extends AbstractPlugin implements CompanyBusinessUnitExpanderPluginInterface
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
    public function expand(CompanyBusinessUnitTransfer $companyBusinessUnitTransfer): CompanyBusinessUnitTransfer
    {
        return $this->getFacade()->expandCompanyBusinessUnit($companyBusinessUnitTransfer);
    }
}
