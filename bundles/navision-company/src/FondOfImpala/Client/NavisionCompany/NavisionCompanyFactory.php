<?php

namespace FondOfImpala\Client\NavisionCompany;

use FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface;
use FondOfImpala\Client\NavisionCompany\Zed\NavisionCompanyStub;
use FondOfImpala\Client\NavisionCompany\Zed\NavisionCompanyStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class NavisionCompanyFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\NavisionCompany\Zed\NavisionCompanyStubInterface
     */
    public function createZedNavisionCompanyStub(): NavisionCompanyStubInterface
    {
        return new NavisionCompanyStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface
     */
    protected function getZedRequestClient(): NavisionCompanyToZedRequestClientInterface
    {
        return $this->getProvidedDependency(NavisionCompanyDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
