<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Persistence;

use FondOfImpala\Zed\NavisionCompanyUser\NavisionCompanyUserDependencyProvider;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserRepositoryInterface getRepository()
 */
class NavisionCompanyUserPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(NavisionCompanyUserDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }
}
