<?php

namespace FondOfImpala\Zed\CompanyType\Persistence;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeRepositoryInterface
{
    /**
     * Specification:
     * - Returns a CompanyTypeTransfer by company type id.
     * - Returns null in case a record is not found.
     *
     * @api
     *
     * @param int $idCompanyType
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getById(int $idCompanyType): ?CompanyTypeTransfer;

    /**
     * Specification:
     * - Returns a CompanyTypeTransfer by company type name.
     * - Returns null in case a record is not found.
     *
     * @api
     *
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getByName(string $name): ?CompanyTypeTransfer;

    /**
     * Specification:
     * - Returns a CompanyTypeCollectionTransfer.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getAll(): CompanyTypeCollectionTransfer;

    /**
     * Specification:
     * - Returns a Companies by Company Type Ids
     *
     * @api
     *
     * @param array $companyTypeIds
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    public function findCompaniesByCompanyTypeIds(array $companyTypeIds): ?CompanyCollectionTransfer;

    /**
     * Specification:
     * - Returns a Company type for the company
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeByIdCompany(CompanyTransfer $companyTransfer): ?CompanyTypeTransfer;
}
