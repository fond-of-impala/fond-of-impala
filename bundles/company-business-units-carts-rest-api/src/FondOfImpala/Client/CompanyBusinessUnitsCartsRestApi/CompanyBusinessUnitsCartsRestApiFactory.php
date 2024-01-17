<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi;

use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed\CompanyBusinessUnitsCartsRestApiZedStub;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed\CompanyBusinessUnitsCartsRestApiZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyBusinessUnitsCartsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed\CompanyBusinessUnitsCartsRestApiZedStubInterface
     */
    public function createCompanyBusinessUnitsCartsRestApiZedStub(): CompanyBusinessUnitsCartsRestApiZedStubInterface
    {
        return new CompanyBusinessUnitsCartsRestApiZedStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitsCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
