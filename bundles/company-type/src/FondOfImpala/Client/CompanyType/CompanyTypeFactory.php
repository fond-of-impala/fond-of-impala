<?php

namespace FondOfImpala\Client\CompanyType;

use FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientInterface;
use FondOfImpala\Client\CompanyType\Zed\CompanyTypeStub;
use FondOfImpala\Client\CompanyType\Zed\CompanyTypeStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyTypeFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyType\Zed\CompanyTypeStubInterface
     */
    public function createZedCompanyTypeStub(): CompanyTypeStubInterface
    {
        return new CompanyTypeStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyTypeToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyTypeDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
