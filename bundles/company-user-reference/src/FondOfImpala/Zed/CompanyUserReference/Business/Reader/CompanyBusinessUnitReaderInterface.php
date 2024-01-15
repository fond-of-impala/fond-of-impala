<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface CompanyBusinessUnitReaderInterface
{
    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function getByCompanyUserReference(string $companyUserReference): ?CompanyBusinessUnitTransfer;
}
