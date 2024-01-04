<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface NavisionCompanyBusinessUnitRepositoryInterface
{
    /**
     * Specification:
     *  - Retrieve a company business unit by CompanyBusinessUnitTransfer::externalReference
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findCompanyBusinessUnitByExternalReference(string $externalReference): ?CompanyBusinessUnitTransfer;
}
