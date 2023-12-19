<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade;

use FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;

class CompanyCompanyTypeGuiToCompanyTypeFacadeBridge implements CompanyCompanyTypeGuiToCompanyTypeFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(CompanyTypeFacadeInterface $companyTypeFacade)
    {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getCompanyTypes(): CompanyTypeCollectionTransfer
    {
        return $this->companyTypeFacade->getCompanyTypes();
    }
}
