<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Mapper;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionKeyMapper implements PermissionKeyMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer
     *
     * @return array<string>
     */
    public function fromPermissionCollection(PermissionCollectionTransfer $permissionCollectionTransfer): array
    {
        $permissionKeys = [];

        foreach ($permissionCollectionTransfer->getPermissions() as $permissionTransfer) {
            $permissionKey = $this->fromPermission($permissionTransfer);

            if ($permissionKey === null) {
                continue;
            }

            $permissionKeys[] = $permissionKey;
        }

        return array_unique($permissionKeys);
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return string|null
     */
    public function fromPermission(PermissionTransfer $permissionTransfer): ?string
    {
        return $permissionTransfer->getKey();
    }
}
