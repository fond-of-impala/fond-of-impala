<?php

namespace FondOfImpala\Zed\CompanyUserReference\Dependency\Facade;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyUserReferenceToCompanyFacadeInterface
{
    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findCompanyById(int $idCompany): ?CompanyTransfer;
}
