<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeRoleToCompanyTypeFacadeBridge implements CompanyTypeRoleToCompanyTypeFacadeInterface
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
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getCompanyTypeById($companyTypeTransfer);
    }

    /**
     * @return string
     */
    public function getCompanyTypeManufacturerName(): string
    {
        return $this->companyTypeFacade->getCompanyTypeManufacturerName();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeByIdCompany(CompanyTransfer $companyTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->findCompanyTypeByIdCompany($companyTransfer);
    }
}
