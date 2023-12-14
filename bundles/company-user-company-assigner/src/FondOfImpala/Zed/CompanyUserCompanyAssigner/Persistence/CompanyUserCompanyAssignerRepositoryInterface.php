<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CompanyUserCompanyAssignerRepositoryInterface
{
    /**
     * @param int $idCompany
     * @param string $companyRoleName
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    public function findCompanyRoleTransferByIdCompanyAndCompanyRoleName(
        int $idCompany,
        string $companyRoleName
    ): ?CompanyRoleTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByIdCompanyAndIdCustomer(
        CompanyTransfer $companyTransfer,
        CustomerTransfer $customerTransfer
    ): ?CompanyUserTransfer;

    /**
     * @param int $idCompanyUser
     *
     * @return string|null
     */
    public function findCompanyTypeNameByIdCompanyUser(int $idCompanyUser): ?string;

    /**
     * @param int $idCompany
     *
     * @return string|null
     */
    public function findCompanyTypeNameByIdCompany(int $idCompany): ?string;

    /**
     * @param string $companyTypeNameForManufacturer
     * @param string $companyRoleName
     *
     * @return array<int, array<string, int>>
     */
    public function findNonManufacturerData(
        string $companyTypeNameForManufacturer,
        string $companyRoleName
    ): array;

    /**
     * @param int $idCompanyRole
     *
     * @return string|null
     */
    public function findCompanyRoleNameByIdCompanyRole(int $idCompanyRole): ?string;

    /**
     * @param int $IdCustomer
     * @param int $IdCompanyType
     *
     * @return array<int, int>
     */
    public function findCompanyIdsByIdCustomerAndIdCompanyType(
        int $IdCustomer,
        int $IdCompanyType
    ): array;

    /**
     * @param int $idCustomer
     * @param string $companyRoleName
     * @param array<int> $companyIds
     *
     * @return array<int, array<string, mixed>>
     */
    public function findNonManufacturerUsersWithInconsistentCompanyRoles(
        int $idCustomer,
        string $companyRoleName,
        array $companyIds
    );

    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function getCompanyRoleCollectionByCompanyId(int $idCompany): CompanyRoleCollectionTransfer;
}
