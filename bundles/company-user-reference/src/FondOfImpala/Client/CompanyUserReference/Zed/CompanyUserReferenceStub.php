<?php

namespace FondOfImpala\Client\CompanyUserReference\Zed;

use FondOfImpala\Client\CompanyUserReference\Dependency\Client\CompanyUserReferenceToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReferenceStub implements CompanyUserReferenceStubInterface
{
    /**
     * @var \FondOfImpala\Client\CompanyUserReference\Dependency\Client\CompanyUserReferenceToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CompanyUserReference\Dependency\Client\CompanyUserReferenceToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyUserReferenceToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer */
        $companyUserResponseTransfer = $this->zedRequestClient->call(
            '/company-user-reference/gateway/find-company-user-by-company-user-reference',
            $companyUserTransfer,
        );

        return $companyUserResponseTransfer;
    }
}
