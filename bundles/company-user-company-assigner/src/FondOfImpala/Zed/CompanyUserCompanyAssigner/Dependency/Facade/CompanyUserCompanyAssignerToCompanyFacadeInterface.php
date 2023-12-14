<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyUserCompanyAssignerToCompanyFacadeInterface
{
    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findCompanyById(int $idCompany): ?CompanyTransfer;
}
