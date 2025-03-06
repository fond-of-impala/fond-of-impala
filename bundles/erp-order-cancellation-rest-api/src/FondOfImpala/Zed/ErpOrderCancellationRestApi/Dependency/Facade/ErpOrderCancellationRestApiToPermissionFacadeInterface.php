<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

interface ErpOrderCancellationRestApiToPermissionFacadeInterface
{
    /**
     * @param string $permissionKey
     * @param string $identifier
     *
     * @return bool
     */
    public function can(string $permissionKey, string $identifier): bool;
}
