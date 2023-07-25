<?php

namespace FondOfImpala\Client\CompanyType\Zed;

use FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeStub implements CompanyTypeStubInterface
{
    /**
     * @var \FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyTypeToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CompanyTypeResponseTransfer $companyTypeResponseTransfer */
        $companyTypeResponseTransfer = $this->zedRequestClient->call(
            '/company-type/gateway/find-company-type-by-id',
            $companyTypeTransfer,
        );

        return $companyTypeResponseTransfer;
    }
}
