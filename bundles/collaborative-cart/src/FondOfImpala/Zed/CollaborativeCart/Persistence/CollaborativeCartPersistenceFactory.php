<?php

namespace FondOfImpala\Zed\CollaborativeCart\Persistence;

use FondOfImpala\Zed\CollaborativeCart\CollaborativeCartDependencyProvider;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Mapper\CompanyUserMapper;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Mapper\CompanyUserMapperInterface;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\CollaborativeCart\CollaborativeCartConfig getConfig()
 */
class CollaborativeCartPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CollaborativeCartDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Mapper\CompanyUserMapperInterface
     */
    public function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }
}
