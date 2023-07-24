<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Intersection;

use ArrayObject;
use Generated\Shared\Transfer\PermissionCollectionTransfer;

class PermissionIntersection implements PermissionIntersectionInterface
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
    ): PermissionCollectionTransfer {
        $intersectedPermissionTransfers = new ArrayObject();

        foreach ($permissionCollectionTransfer->getPermissions() as $permissionTransfer) {
            $key = $permissionTransfer->getKey();

            if ($key === null || !in_array($key, $keys)) {
                continue;
            }

            $intersectedPermissionTransfers->append($permissionTransfer);
        }

        return (new PermissionCollectionTransfer())
            ->setPermissions($intersectedPermissionTransfers);
    }
}
