<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Reader;

use FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\PermissionSetTransfer;
use Generated\Shared\Transfer\SyncableCompanyRoleTransfer;

class CompanyRoleReader implements CompanyRoleReaderInterface
{
    protected PermissionReaderInterface $permissionReader;

    protected PermissionKeyMapperInterface $permissionKeyMapper;

    protected CompanyTypeRoleRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\PermissionReaderInterface $permissionReader
     * @param \FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface $permissionKeyMapper
     * @param \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface $repository
     */
    public function __construct(
        PermissionReaderInterface $permissionReader,
        PermissionKeyMapperInterface $permissionKeyMapper,
        CompanyTypeRoleRepositoryInterface $repository
    ) {
        $this->permissionReader = $permissionReader;
        $this->permissionKeyMapper = $permissionKeyMapper;
        $this->repository = $repository;
    }

    /**
     * @return array<\Generated\Shared\Transfer\SyncableCompanyRoleTransfer>
     */
    public function findSyncableCompanyRoles(): array
    {
        $syncableCompanyRoles = [];
        $permissionSets = $this->permissionReader->getPermissionSets();

        foreach ($permissionSets as $permissionSet) {
            $syncableCompanyRole = $this->findSyncableCompanyRoleByPermissionSet($permissionSet);

            if ($syncableCompanyRole === null) {
                continue;
            }

            $syncableCompanyRoles[] = $syncableCompanyRole;
        }

        return $syncableCompanyRoles;
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionSetTransfer $permissionSetTransfer
     *
     * @return \Generated\Shared\Transfer\SyncableCompanyRoleTransfer|null
     */
    public function findSyncableCompanyRoleByPermissionSet(
        PermissionSetTransfer $permissionSetTransfer
    ): ?SyncableCompanyRoleTransfer {
        $companyType = $permissionSetTransfer->getCompanyType();
        $companyRoleName = $permissionSetTransfer->getCompanyRoleName();
        $permissionCollectionTransfer = $permissionSetTransfer->getEntries();

        if (
            $companyType === null ||
            $companyRoleName === null ||
            $permissionCollectionTransfer === null ||
            $permissionCollectionTransfer->getPermissions()->count() < 1
        ) {
            return null;
        }

        $permissionKeys = $this->permissionKeyMapper->fromPermissionCollection($permissionCollectionTransfer);
        $companyRolesIds = $this->repository->findSyncableCompanyRoleIds(
            $companyType,
            $companyRoleName,
            $permissionKeys,
        );

        return (new SyncableCompanyRoleTransfer())->setIds($companyRolesIds)
            ->setName($companyRoleName)
            ->setCompanyType($companyType)
            ->setPermissions($permissionCollectionTransfer);
    }

    /**
     * @param array<int> $companyRoleIds
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function findCompanyRolesByCompanyRoleIds(array $companyRoleIds): CompanyRoleCollectionTransfer
    {
        return $this->repository->findCompanyRolesByCompanyRoleIds($companyRoleIds);
    }
}
