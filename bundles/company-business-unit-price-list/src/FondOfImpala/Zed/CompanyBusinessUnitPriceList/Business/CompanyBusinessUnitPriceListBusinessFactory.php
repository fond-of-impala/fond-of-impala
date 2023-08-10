<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business;

use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpander;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpanderInterface;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\CompanyBusinessUnitPriceListDependencyProvider;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CompanyBusinessUnitPriceListBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpanderInterface
     */
    public function createCompanyBusinessUnitExpander(): CompanyBusinessUnitExpanderInterface
    {
        return new CompanyBusinessUnitExpander($this->getPriceListFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface
     */
    protected function getPriceListFacade(): CompanyBusinessUnitPriceListToPriceListFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitPriceListDependencyProvider::FACADE_PRICE_LIST);
    }
}
