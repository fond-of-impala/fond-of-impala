<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;

class CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge implements CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
{
    /**
     * @var \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @param \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     */
    public function __construct(CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade)
    {
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
    }

    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function findDefaultBusinessUnitByCompanyId(int $idCompany): CompanyBusinessUnitTransfer
    {
        return $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId($idCompany);
    }

    /**
     * @param int $idCompanyBusinessUnit
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findCompanyBusinessUnitById(int $idCompanyBusinessUnit): ?CompanyBusinessUnitTransfer
    {
        return $this->companyBusinessUnitFacade->findCompanyBusinessUnitById($idCompanyBusinessUnit);
    }
}
