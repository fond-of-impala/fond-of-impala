<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Persistence;

use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Expander\CompanyUserQueryExpander;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Expander\CompanyUserQueryExpanderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Mapper\CompanyUserMapper;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Mapper\CompanyUserMapperInterface;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleToCompanyUserQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface getRepository()
 */
class CompanyUsersRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserPropelQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }

    /**
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleToCompanyUserQuery
     */
    public function getCompanyRoleToCompanyUserPropelQuery(): SpyCompanyRoleToCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::PROPEL_QUERY_COMPANY_ROLE_TO_COMPANY_USER);
    }

    /**
     * @return array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\QueryExpander\CompanyUserQueryExpanderPluginInterface>
     */
    public function getCompanyUserQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_QUERY_EXPANDER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Mapper\CompanyUserMapperInterface
     */
    public function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Expander\CompanyUserQueryExpanderInterface
     */
    public function createCompanyUserQueryExpander(): CompanyUserQueryExpanderInterface
    {
        return new CompanyUserQueryExpander($this->getCompanyUserQueryExpanderPlugins());
    }
}
