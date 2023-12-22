<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeConverterToCompanyTypeFacadeBridge implements CompanyTypeConverterToCompanyTypeFacadeInterface
{
    protected CompanyTypeFacadeInterface $companyTypeFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(CompanyTypeFacadeInterface $companyTypeFacade)
    {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeResponseTransfer
    {
        return $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);
    }
}
