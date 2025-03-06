<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class ErpOrderCancellationRestApiToCompanyUserReferenceFacadeBridge implements ErpOrderCancellationRestApiToCompanyUserReferenceFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface
     */
    protected CompanyUserReferenceFacadeInterface $companyUserReferenceFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface $companyUserFacade
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
    ): CompanyUserResponseTransfer{
        return $this->companyUserReferenceFacade
            ->findCompanyUserByCompanyUserReference($companyUserTransfer);
    }
}
