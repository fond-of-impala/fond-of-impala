<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCustomerCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUsersBulkRestApiRepositoryInterface
{
    /**
     * @param string $permissionKey
     * @param string $customerReference
     *
     * @return bool
     */
    public function hasPermission(
        string $permissionKey,
        string $customerReference
    ): bool;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return bool
     */
    public function isCompanyUserAlreadyAvailable(CompanyUserTransfer $companyUserTransfer): bool;

    /**
     * @param array $emailAddresses
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkCustomerCollectionTransfer
     */
    public function findCustomerByEmail(array $emailAddresses): CompanyUsersBulkCustomerCollectionTransfer;

    /**
     * @param int $idCompany
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUsersByFkCompanyAndFkCustomer(int $idCompany, int $idCustomer): CompanyUserCollectionTransfer;

    /**
     * @param array $customerReferences
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkCustomerCollectionTransfer
     */
    public function findCustomerByReferences(array $customerReferences): CompanyUsersBulkCustomerCollectionTransfer;

    /**
     * @param array $companyUuids
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer
     */
    public function findCompaniesByUuids(array $companyUuids): CompanyUsersBulkCompanyCollectionTransfer;

    /**
     * @param array<int> $companyIds
     *
     * @return array<int, array<int, \Generated\Shared\Transfer\CompanyUsersBulkCompanyBusinessUnitTransfer>>
     */
    public function findCompanyBusinessUnitsByIdCompany(array $companyIds): array;

    /**
     * @param array<int> $companyIds
     *
     * @return array<int, array<int, \Generated\Shared\Transfer\CompanyUsersBulkCompanyRoleTransfer>>
     */
    public function findCompanyRolesByCompanyIds(array $companyIds): array;
}
