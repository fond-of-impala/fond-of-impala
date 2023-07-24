<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;

class CompanyTypeRoleToCompanyFacadeBridge implements CompanyTypeRoleToCompanyFacadeInterface
{
    /**
     * @var \Spryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @param \Spryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     */
    public function __construct(CompanyFacadeInterface $companyFacade)
    {
        $this->companyFacade = $companyFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanies(): CompanyCollectionTransfer
    {
        return $this->companyFacade->getCompanies();
    }
}
