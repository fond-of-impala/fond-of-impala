<?php

namespace FondOfImpala\Zed\PermissionCartSearchRestApi\Persistence;

use Orm\Zed\Permission\Persistence\Map\SpyPermissionTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\PermissionCartSearchRestApi\Persistence\PermissionCartSearchRestApiPersistenceFactory getFactory()
 */
class PermissionCartSearchRestApiRepository extends AbstractRepository implements PermissionCartSearchRestApiRepositoryInterface
{
    /**
     * @param string $key
     *
     * @return int|null
     */
    public function getIdPermissionByKey(string $key): ?int
    {
        /** @var int|null $idPermission */
        $idPermission = $this->getFactory()
            ->getPermissionQuery()
            ->clear()
            ->filterByKey($key)
            ->select([SpyPermissionTableMap::COL_ID_PERMISSION])
            ->findOne();

        return $idPermission;
    }
}
