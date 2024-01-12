<?php

namespace FondOfImpala\Client\CompanyUserReference;

use FondOfImpala\Client\CompanyUserReference\Dependency\Client\CompanyUserReferenceToZedRequestClientInterface;
use FondOfImpala\Client\CompanyUserReference\Zed\CompanyUserReferenceStub;
use FondOfImpala\Client\CompanyUserReference\Zed\CompanyUserReferenceStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyUserReferenceFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyUserReference\Zed\CompanyUserReferenceStubInterface
     */
    public function createZedCompanyUserReferenceStub(): CompanyUserReferenceStubInterface
    {
        return new CompanyUserReferenceStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CompanyUserReference\Dependency\Client\CompanyUserReferenceToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyUserReferenceToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyUserReferenceDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
