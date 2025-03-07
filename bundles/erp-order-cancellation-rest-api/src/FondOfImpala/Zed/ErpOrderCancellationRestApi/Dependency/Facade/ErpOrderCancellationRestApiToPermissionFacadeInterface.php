<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

interface ErpOrderCancellationRestApiToPermissionFacadeInterface
{
    /**
     * @param string $permissionKey
     * @param int|null $identifier
     *
     * @return bool
     */
    public function can(string $permissionKey,  ?int $identifier): bool;
}
