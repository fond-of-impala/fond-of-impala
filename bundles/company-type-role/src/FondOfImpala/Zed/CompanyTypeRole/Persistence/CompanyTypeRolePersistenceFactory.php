<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence;

use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface getRepository()
 */
class CompanyTypeRolePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }
}
