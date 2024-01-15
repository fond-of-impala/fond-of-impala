<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade;

use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserQuoteToCompanyUserReferenceFacadeBridge implements CompanyUserQuoteToCompanyUserReferenceFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     */
    public function __construct(CompanyUserReferenceFacadeInterface $companyUserReferenceFacade)
    {
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        return $this->companyUserReferenceFacade->findCompanyUserByCompanyUserReference($companyUserTransfer);
    }
}
