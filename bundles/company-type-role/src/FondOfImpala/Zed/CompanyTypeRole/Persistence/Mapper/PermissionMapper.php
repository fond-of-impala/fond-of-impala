<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;

/**
 * @codeCoverageIgnore
 */
class PermissionMapper implements PermissionMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\SpyCompanyRole $spyCompanyRole
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function fromSpyCompanyRole(SpyCompanyRole $spyCompanyRole): PermissionCollectionTransfer
    {
        $permissionCollectionTransfer = new PermissionCollectionTransfer();

        foreach ($spyCompanyRole->getPermissions() as $spyPermission) {
            $permissionTransfer = (new PermissionTransfer())
                ->fromArray($spyPermission->toArray(), true);

            $permissionCollectionTransfer->addPermission($permissionTransfer);
        }

        return $permissionCollectionTransfer;
    }
}
