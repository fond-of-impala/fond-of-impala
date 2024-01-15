<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyReaderInterface
{
    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function getByCompanyUserReference(string $companyUserReference): ?CompanyTransfer;
}
