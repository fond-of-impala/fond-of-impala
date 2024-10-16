<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence;

use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\PermissionErpOrderCancellationRestApiDependencyProvider;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Permission\Persistence\Base\SpyPermissionQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class PermissionErpOrderCancellationRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Permission\Persistence\Base\SpyPermissionQuery
     */
    public function getPermissionQuery(): SpyPermissionQuery
    {
        return $this->getProvidedDependency(
            PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_PERMISSION,
        );
    }

    /**
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(
            PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_COMPANY,
        );
    }

    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(
            PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_COMPANY_USER,
        );
    }

    /**
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery
     */
    public function getCompanyRoleQuery(): SpyCompanyRoleQuery
    {
        return $this->getProvidedDependency(
            PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_COMPANY_ROLE,
        );
    }
}
