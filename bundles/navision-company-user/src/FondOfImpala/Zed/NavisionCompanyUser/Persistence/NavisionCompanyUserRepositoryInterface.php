<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface NavisionCompanyUserRepositoryInterface
{
    /**
     * Specification:
     *  - Retrieve a company user by CompanyUserTransfer::externalReference
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByExternalReference(string $externalReference): ?CompanyUserTransfer;
}
