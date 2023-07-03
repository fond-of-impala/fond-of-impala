<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence;

use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorDependencyProvider;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class CustomerAnonymizerCompanyUserConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CustomerAnonymizerCompanyUserConnectorDependencyProvider::QUERY_COMPANY_USER);
    }
}
