<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;

interface CompanyTypeRoleRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function findActiveCompanyUserIdsByIdCustomer(int $idCustomer): array;

    /**
     * @param string $companyTypeName
     * @param string $companyRoleName
     * @param array<string> $permissionKeys
     *
     * @return array<int>
     */
    public function findSyncableCompanyRoleIds(
        string $companyTypeName,
        string $companyRoleName,
        array $permissionKeys
    ): array;

    /**
     * @param array<int> $companyRoleIds
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function findCompanyRolesByCompanyRoleIds(
        array $companyRoleIds
    ): CompanyRoleCollectionTransfer;
}
