<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Mapper;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

interface PermissionKeyMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer
     *
     * @return array<string>
     */
    public function fromPermissionCollection(
        PermissionCollectionTransfer $permissionCollectionTransfer
    ): array;

    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return string|null
     */
    public function fromPermission(PermissionTransfer $permissionTransfer): ?string;
}
