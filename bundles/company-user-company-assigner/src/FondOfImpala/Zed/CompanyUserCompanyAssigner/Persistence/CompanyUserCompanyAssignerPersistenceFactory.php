<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapper;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyUserMapper;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyUserMapperInterface;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\CompanyType\Persistence\Base\FoiCompanyTypeQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface getRepository()
 */
class CompanyUserCompanyAssignerPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapperInterface
     */
    public function createCompanyRoleMapper(): CompanyRoleMapperInterface
    {
        return new CompanyRoleMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyUserMapperInterface
     */
    public function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }

    /**
     * @return \Orm\Zed\Company\Persistence\Base\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY);
    }

    /**
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery
     */
    public function getCompanyRoleQuery(): SpyCompanyRoleQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY_ROLE);
    }

    /**
     * @return \Orm\Zed\CompanyType\Persistence\Base\FoiCompanyTypeQuery
     */
    public function getCompanyTypeQuery(): FoiCompanyTypeQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY_TYPE);
    }

    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }
}
