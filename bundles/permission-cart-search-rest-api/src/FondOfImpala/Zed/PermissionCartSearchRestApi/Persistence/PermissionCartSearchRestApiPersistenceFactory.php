<?php

namespace FondOfImpala\Zed\PermissionCartSearchRestApi\Persistence;

use FondOfImpala\Zed\PermissionCartSearchRestApi\PermissionCartSearchRestApiDependencyProvider;
use Orm\Zed\Permission\Persistence\Base\SpyPermissionQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class PermissionCartSearchRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Permission\Persistence\Base\SpyPermissionQuery
     */
    public function getPermissionQuery(): SpyPermissionQuery
    {
        return $this->getProvidedDependency(
            PermissionCartSearchRestApiDependencyProvider::PROPEL_QUERY_PERMISSION,
        );
    }
}
