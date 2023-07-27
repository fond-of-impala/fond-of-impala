<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeConverterToCompanyTypeFacadeBridge implements CompanyTypeConverterToCompanyTypeFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface $companyTypeFacade
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
