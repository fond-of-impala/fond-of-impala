<?php

namespace FondOfImpala\Zed\CompanyPriceListGui\Communication;

use FondOfImpala\Zed\CompanyPriceListGui\Communication\Form\CompanyPriceListForm;
use FondOfImpala\Zed\CompanyPriceListGui\Communication\Form\DataProvider\CompanyPriceListFormDataProvider;
use FondOfImpala\Zed\CompanyPriceListGui\CompanyPriceListGuiDependencyProvider;
use FondOfImpala\Zed\CompanyPriceListGui\Dependency\Facade\CompanyPriceListGuiToPriceListFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CompanyPriceListGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyPriceListGui\Dependency\Facade\CompanyPriceListGuiToPriceListFacadeInterface
     */
    protected function getPriceListFacade(): CompanyPriceListGuiToPriceListFacadeInterface
    {
        return $this->getProvidedDependency(CompanyPriceListGuiDependencyProvider::FACADE_PRICE_LIST);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyPriceListGui\Communication\Form\DataProvider\CompanyPriceListFormDataProvider
     */
    public function createCompanyPriceListFormDataProvider(): CompanyPriceListFormDataProvider
    {
        return new CompanyPriceListFormDataProvider($this->getPriceListFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyPriceListGui\Communication\Form\CompanyPriceListForm
     */
    public function createCompanyPriceListForm(): CompanyPriceListForm
    {
        return new CompanyPriceListForm();
    }
}
