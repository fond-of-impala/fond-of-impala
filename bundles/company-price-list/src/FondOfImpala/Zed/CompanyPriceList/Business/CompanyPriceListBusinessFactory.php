<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business;

use FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydrator;
use FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydratorInterface;
use FondOfImpala\Zed\CompanyPriceList\CompanyPriceListDependencyProvider;
use FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CompanyPriceListBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydratorInterface
     */
    public function createCompanyHydrator(): CompanyHydratorInterface
    {
        return new CompanyHydrator($this->getPriceListFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface
     */
    protected function getPriceListFacade(): CompanyPriceListToPriceListFacadeInterface
    {
        return $this->getProvidedDependency(CompanyPriceListDependencyProvider::FACADE_PRICE_LIST);
    }
}
