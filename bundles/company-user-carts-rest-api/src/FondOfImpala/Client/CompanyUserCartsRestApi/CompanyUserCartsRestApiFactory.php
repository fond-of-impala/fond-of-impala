<?php

namespace FondOfImpala\Client\CompanyUserCartsRestApi;

use FondOfImpala\Client\CompanyUserCartsRestApi\Dependency\Client\CompanyUserCartsRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyUserCartsRestApi\Zed\CompanyUserCartsRestApiStub;
use FondOfImpala\Client\CompanyUserCartsRestApi\Zed\CompanyUserCartsRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyUserCartsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyUserCartsRestApi\Dependency\Client\CompanyUserCartsRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyUserCartsRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }

    /**
     * @return \FondOfImpala\Client\CompanyUserCartsRestApi\Zed\CompanyUserCartsRestApiStubInterface
     */
    public function createCompanyUserCartsRestApiStub(): CompanyUserCartsRestApiStubInterface
    {
        return new CompanyUserCartsRestApiStub(
            $this->getZedRequestClient(),
        );
    }
}
