<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Reader;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\PermissionSetTransfer;
use Generated\Shared\Transfer\SyncableCompanyRoleTransfer;

interface CompanyRoleReaderInterface
{
    /**
     * @return array<\Generated\Shared\Transfer\SyncableCompanyRoleTransfer>
     */
    public function findSyncableCompanyRoles(): array;

    /**
     * @param \Generated\Shared\Transfer\PermissionSetTransfer $permissionSetTransfer
     *
     * @return \Generated\Shared\Transfer\SyncableCompanyRoleTransfer|null
     */
    public function findSyncableCompanyRoleByPermissionSet(
        PermissionSetTransfer $permissionSetTransfer
    ): ?SyncableCompanyRoleTransfer;

    /**
     * @param array<int> $companyRoleIds
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function findCompanyRolesByCompanyRoleIds(array $companyRoleIds): CompanyRoleCollectionTransfer;
}
