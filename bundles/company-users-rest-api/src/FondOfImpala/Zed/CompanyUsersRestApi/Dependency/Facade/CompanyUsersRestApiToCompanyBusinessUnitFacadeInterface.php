<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
{
    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findDefaultBusinessUnitByCompanyId(int $idCompany): ?CompanyBusinessUnitTransfer;
}
