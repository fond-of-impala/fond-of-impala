<?php

namespace FondOfImpala\Zed\CompanyType\Persistence;

use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeEntityManagerInterface
{
    /**
     * Specification:
     * - Create or update a company type.
     * - Finds a company type by CompanyTypeTransfer::idCompanyType.
     * - Persists the entity to DB.
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function persist(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer;

    /**
     * Specification:
     * - Finds a company type by ID.
     * - Deletes the company type.
     *
     * @param int $idCompanyType
     *
     * @return void
     */
    public function deleteById(int $idCompanyType): void;
}
