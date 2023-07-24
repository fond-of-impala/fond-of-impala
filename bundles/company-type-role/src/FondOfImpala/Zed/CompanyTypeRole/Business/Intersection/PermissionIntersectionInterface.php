<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Intersection;

use Generated\Shared\Transfer\PermissionCollectionTransfer;

interface PermissionIntersectionInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer
     * @param array<string> $keys
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function intersect(
        PermissionCollectionTransfer $permissionCollectionTransfer,
        array $keys
    ): PermissionCollectionTransfer;
}
