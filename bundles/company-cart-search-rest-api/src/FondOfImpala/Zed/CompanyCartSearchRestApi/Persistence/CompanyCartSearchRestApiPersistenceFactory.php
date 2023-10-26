<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence;

use FondOfImpala\Zed\CompanyCartSearchRestApi\CompanyCartSearchRestApiDependencyProvider;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Orm\Zed\Permission\Persistence\Base\SpyPermissionQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class CompanyCartSearchRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\Base\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(
            CompanyCartSearchRestApiDependencyProvider::PROPEL_QUERY_COMPANY,
        );
    }

    /**
     * @return \Orm\Zed\Permission\Persistence\Base\SpyPermissionQuery
     */
    public function getPermissionQuery(): SpyPermissionQuery
    {
        return $this->getProvidedDependency(
            CompanyCartSearchRestApiDependencyProvider::PROPEL_QUERY_PERMISSION,
        );
    }
}
