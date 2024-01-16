<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

interface CompanyUserCartsRestApiToPermissionFacadeInterface
{
    /**
     * @param string $permissionKey
     * @param string|int $identifier
     * @param array|string|int|null $context
     *
     * @return bool
     */
    public function can(string $permissionKey, string|int $identifier, array|string|int|null $context = null): bool;
}
