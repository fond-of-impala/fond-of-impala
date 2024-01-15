<?php

namespace FondOfImpala\Zed\CompanyUserReference\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserReferenceRepositoryInterface
{
    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByCompanyUserReference(string $companyUserReference): ?CompanyUserTransfer;

    /**
     * @param string $companyUserReference
     *
     * @return int|null
     */
    public function findIdCompanyByCompanyUserReference(string $companyUserReference): ?int;

    /**
     * @param string $companyUserReference
     *
     * @return int|null
     */
    public function findIdCompanyBusinessUnitByCompanyUserReference(string $companyUserReference): ?int;

    /**
     * @param string $companyUserReference
     * @param int $fkCustomer
     *
     * @return int|null
     */
    public function findIdCompanyUserByCompanyUserReferenceAndFkCustomer(
        string $companyUserReference,
        int $fkCustomer
    ): ?int;
}
