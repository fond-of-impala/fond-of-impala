<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Communication;

use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider\CompanyCompanyTypeFormDataProvider;
use FondOfImpala\Zed\CompanyCompanyTypeGui\CompanyCompanyTypeGuiDependencyProvider;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CompanyCompanyTypeGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyCompanyTypeGuiToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyCompanyTypeGuiDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider\CompanyCompanyTypeFormDataProvider
     */
    public function createCompanyCompanyTypeFormDataProvider(): CompanyCompanyTypeFormDataProvider
    {
        return new CompanyCompanyTypeFormDataProvider($this->getCompanyTypeFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm
     */
    public function createCompanyCompanyTypeForm(): CompanyCompanyTypeForm
    {
        return new CompanyCompanyTypeForm();
    }
}
