<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUsersRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return array<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    public function findActiveCompanyUsersByCustomerReference(string $customerReference): array;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUsersByFilter(
        CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
    ): CompanyUserCollectionTransfer;

    /**
     * @param int $idCustomer
     * @param string $foreignCompanyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByIdCustomerAndForeignCompanyUserReference(
        int $idCustomer,
        string $foreignCompanyUserReference
    ): ?CompanyUserTransfer;

    /**
     * @param int $idCompany
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUserByFkCompany(
        int $idCompany
    ): CompanyUserCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return array<string>
     */
    public function findCompanyUserRolesByCompanyUser(
        CompanyUserTransfer $companyUserTransfer
    ): array;

    /**
     * @param int $idCompany
     *
     * @return array<int, array>
     */
    public function findCompanyUserRolesByFkCompany(int $idCompany): array;
}
