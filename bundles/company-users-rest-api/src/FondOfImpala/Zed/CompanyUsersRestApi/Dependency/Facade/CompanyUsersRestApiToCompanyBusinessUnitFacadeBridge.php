<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;

class CompanyUsersRestApiToCompanyBusinessUnitFacadeBridge implements CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
{
    protected CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade;

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
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findDefaultBusinessUnitByCompanyId(int $idCompany): ?CompanyBusinessUnitTransfer
    {
        return $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId($idCompany);
    }
}
