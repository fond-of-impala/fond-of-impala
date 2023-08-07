<?php

namespace FondOfImpala\Zed\CompanyPriceList\Communication\Plugin\CompanyExtension;

use FondOfSpryker\Zed\CompanyExtension\Dependency\Plugin\CompanyHydrationPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListFacadeInterface getFacade()
 */
class PriceListCompanyHydrationPlugin extends AbstractPlugin implements CompanyHydrationPluginInterface
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
    public function hydrate(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->getFacade()->hydrateCompany($companyTransfer);
    }
}
