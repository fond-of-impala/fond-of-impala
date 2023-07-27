<?php

namespace FondOfImpala\Zed\CompanyType\Business;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;

interface CompanyTypeFacadeInterface
{
    /**
     * Specification:
     * - Retrieve a company type by CompanyTypeTransfer::idCompanyType in the transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer;

    /**
     * Specification:
     * - Retrieves collection of all company types
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getCompanyTypes(): CompanyTypeCollectionTransfer;

    /**
     * Specification:
     * - Creates a company type
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function createCompanyType(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer;

    /**
     * Specification:
     * - Finds a company type by CompanyTypeTransfer::idCompanyType in the transfer
     * - Updates fields in a company type entity
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function updateCompanyType(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer;

    /**
     * Specification:
     * - Finds a company type by CompanyTypeTransfer::idCompanyType in the transfer
     * - Deletes the company type
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return void
     */
    public function deleteCompanyType(CompanyTypeTransfer $companyTypeTransfer): void;

    /**
     * Specification:
     * - Finds a company type by id.
     * - Requires idCompanyType field to be set in CompanyRoleTransfer taken as parameter.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeResponseTransfer;

    /**
     * Specification:
     * - Finds a company type by Id Company.
     * - Returns null if company type does not exist.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeByIdCompany(CompanyTransfer $companyTransfer): ?CompanyTypeTransfer;

    /**
     * Specification:
     * - Finds companies by company type ids
     * - Returns null if there is no companies in the ids range
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    public function findCompaniesByCompanyTypeIds(
        CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
    ): ?CompanyCollectionTransfer;

    /**
     * Specification:
     * - Finds a company type by CompanyTypeTransfer::name in the transfer
     * - Returns null if there is no company type found
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeByName(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer;

    /**
     * Specification:
     * - Assigns default company type for a company after company create.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignDefaultCompanyTypeToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer;

    /**
     * @return string|null
     */
    public function getCompanyTypeManufacturerName(): ?string;

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeManufacturer(): ?CompanyTypeTransfer;

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $transfer
     *
     * @return bool
     */
    public function validateCompanyTypeForExport(EventEntityTransfer $transfer): bool;
}
