<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use FondOfImpala\Zed\Company\Business\CompanyFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyUserCompanyAssignerToCompanyFacadeBridge implements CompanyUserCompanyAssignerToCompanyFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @param \FondOfImpala\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     */
    public function __construct(CompanyFacadeInterface $companyFacade)
    {
        $this->companyFacade = $companyFacade;
    }

    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findCompanyById(int $idCompany): ?CompanyTransfer
    {
        return $this->companyFacade->findCompanyById($idCompany);
    }
}
