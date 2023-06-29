<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence;

use FondOfImpala\Zed\CustomerCompanyUserConnector\CustomerCompanyUserConnectorDependencyProvider;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class CustomerCompanyUserConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CustomerCompanyUserConnectorDependencyProvider::QUERY_COMPANY_USER);
    }
}
