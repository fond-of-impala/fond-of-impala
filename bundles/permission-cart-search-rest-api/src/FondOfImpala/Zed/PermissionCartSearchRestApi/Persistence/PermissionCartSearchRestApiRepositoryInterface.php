<?php

namespace FondOfImpala\Zed\PermissionCartSearchRestApi\Persistence;

interface PermissionCartSearchRestApiRepositoryInterface
{
    /**
     * @param string $key
     *
     * @return int|null
     */
    public function getIdPermissionByKey(string $key): ?int;
}
