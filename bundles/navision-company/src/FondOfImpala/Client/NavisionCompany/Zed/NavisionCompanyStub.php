<?php

namespace FondOfImpala\Client\NavisionCompany\Zed;

use FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class NavisionCompanyStub implements NavisionCompanyStubInterface
{
    protected NavisionCompanyToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(NavisionCompanyToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByExternalReference(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer */
        $companyResponseTransfer = $this->zedRequestClient
            ->call('/navision-company/gateway/find-company-by-external-reference', $companyTransfer);

        return $companyResponseTransfer;
    }
}
