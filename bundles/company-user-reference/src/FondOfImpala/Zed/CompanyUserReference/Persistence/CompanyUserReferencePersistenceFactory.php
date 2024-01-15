<?php

namespace FondOfImpala\Zed\CompanyUserReference\Persistence;

use FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceDependencyProvider;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface getRepository()
 */
class CompanyUserReferencePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserPropelQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyUserReferenceDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }
}
