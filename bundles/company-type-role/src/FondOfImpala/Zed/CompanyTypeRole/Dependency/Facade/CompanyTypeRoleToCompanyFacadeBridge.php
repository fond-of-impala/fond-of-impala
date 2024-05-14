<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyCriteriaFilterTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;

class CompanyTypeRoleToCompanyFacadeBridge implements CompanyTypeRoleToCompanyFacadeInterface
{
    protected CompanyFacadeInterface $companyFacade;

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

    /**
     * Specification:
     * - Finds companies according to criteria from CompanyCriteriaFilterTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanyCollection(CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer): CompanyCollectionTransfer{
        return $this->companyFacade->getCompanyCollection($companyCriteriaFilterTransfer);
    }
}
