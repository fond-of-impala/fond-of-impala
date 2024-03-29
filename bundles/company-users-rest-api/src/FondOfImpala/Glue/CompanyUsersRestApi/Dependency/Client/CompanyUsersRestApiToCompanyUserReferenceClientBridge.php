<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client;

use FondOfImpala\Client\CompanyUserReference\CompanyUserReferenceClientInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUsersRestApiToCompanyUserReferenceClientBridge implements CompanyUsersRestApiToCompanyUserReferenceClientInterface
{
    protected CompanyUserReferenceClientInterface $companyUserReferenceClient;

    /**
     * @param \FondOfImpala\Client\CompanyUserReference\CompanyUserReferenceClientInterface $companyUserReferenceClient
     */
    public function __construct(CompanyUserReferenceClientInterface $companyUserReferenceClient)
    {
        $this->companyUserReferenceClient = $companyUserReferenceClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        return $this->companyUserReferenceClient->findCompanyUserByCompanyUserReference($companyUserTransfer);
    }
}
