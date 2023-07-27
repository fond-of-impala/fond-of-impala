<?php

namespace FondOfImpala\Client\CompanyUsersBulkRestApi;

use FondOfImpala\Client\CompanyUsersBulkRestApi\Dependency\Client\CompanyUsersBulkRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyUsersBulkRestApi\Zed\CompanyUsersBulkRestApiStub;
use FondOfImpala\Client\CompanyUsersBulkRestApi\Zed\CompanyUsersBulkRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyUsersBulkRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyUsersBulkRestApi\Zed\CompanyUsersBulkRestApiStubInterface
     */
    public function createZedCompanyUsersBulkRestApiStub(): CompanyUsersBulkRestApiStubInterface
    {
        return new CompanyUsersBulkRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CompanyUsersBulkRestApi\Dependency\Client\CompanyUsersBulkRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyUsersBulkRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersBulkRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
