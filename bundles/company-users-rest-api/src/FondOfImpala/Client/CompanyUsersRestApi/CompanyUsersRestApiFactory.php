<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\CompanyUsersRestApi;

use FondOfImpala\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStub;
use FondOfImpala\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyUsersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface
     */
    public function createZedCompanyUsersRestApiStub(): CompanyUsersRestApiStubInterface
    {
        return new CompanyUsersRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyUsersRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
