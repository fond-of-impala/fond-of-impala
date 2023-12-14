<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence;

use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPropelFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\CompanyMapper;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\CompanyMapperInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\CompanyRoleMapper;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\CompanyRoleMapperInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\PermissionMapper;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\PermissionMapperInterface;
use Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface getRepository()
 */
class CompanyTypeRolePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\CompanyRoleMapperInterface
     */
    public function createCompanyRoleMapper(): CompanyRoleMapperInterface
    {
        return new CompanyRoleMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\CompanyMapperInterface
     */
    public function createCompanyMapper(): CompanyMapperInterface
    {
        return new CompanyMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper\PermissionMapperInterface
     */
    public function createPermissionMapper(): PermissionMapperInterface
    {
        return new PermissionMapper();
    }

    /**
     * @return \Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPropelFacadeInterface
     */
    public function getPropelFacade(): CompanyTypeRoleToPropelFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_PROPEL);
    }
}
