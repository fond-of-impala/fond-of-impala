<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider;

use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface;

class CompanyCompanyTypeFormDataProvider
{
    protected CompanyCompanyTypeGuiToCompanyTypeFacadeInterface $companyTypeFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(CompanyCompanyTypeGuiToCompanyTypeFacadeInterface $companyTypeFacade)
    {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [
            CompanyCompanyTypeForm::OPTIONS_COMPANY_TYPE => $this->getCompanyTypeOptions(),
        ];
    }

    /**
     * @return array
     */
    protected function getCompanyTypeOptions(): array
    {
        $companyTypeOptions = [];
        $companyTypeCollectionTransfer = $this->companyTypeFacade->getCompanyTypes();

        foreach ($companyTypeCollectionTransfer->getCompanyTypes() as $companyTypeTransfer) {
            $companyTypeOptions[$companyTypeTransfer->getName()] = $companyTypeTransfer->getIdCompanyType();
        }

        return $companyTypeOptions;
    }
}
