<?php

namespace FondOfImpala\Zed\NavisionCompany\Persistence;

use Generated\Shared\Transfer\CompanyTransfer;

interface NavisionCompanyRepositoryInterface
{
    /**
     * Specification:
     *  - Retrieve a company by CompanyTransfer::externalReference
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findCompanyByExternalReference(string $externalReference): ?CompanyTransfer;

    /**
     * Specification:
     *  - Retrieve a company by CompanyTransfer::debtorNumber
     *
     * @api
     *
     * @param string $debtorNumber
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findCompanyByDebtorNumber(string $debtorNumber): ?CompanyTransfer;
}
