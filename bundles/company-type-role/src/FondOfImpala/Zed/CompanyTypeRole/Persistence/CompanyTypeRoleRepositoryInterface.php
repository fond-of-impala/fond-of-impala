<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;

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

    /**
     * @param int $companyRoleId
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUserIdsByCompanyRoleId(
        int $companyRoleId
    ): CompanyUserCollectionTransfer;

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return int
     */
    public function getCompanyCount(): int;

    /**
     * @param \Generated\Shared\Transfer\CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanyCollection(
        CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
    ): CompanyCollectionTransfer;
}
