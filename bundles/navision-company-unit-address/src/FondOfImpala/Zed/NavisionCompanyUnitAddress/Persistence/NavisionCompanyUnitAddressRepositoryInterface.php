<?php

namespace FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence;

use Generated\Shared\Transfer\CompanyUnitAddressTransfer;

interface NavisionCompanyUnitAddressRepositoryInterface
{
    /**
     * Specification:
     * - Retrieve a company unit address by CompanyUnitAddressTransfer::externalReference
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer|null
     */
    public function findCompanyUnitAddressByExternalReference(string $externalReference): ?CompanyUnitAddressTransfer;
}
