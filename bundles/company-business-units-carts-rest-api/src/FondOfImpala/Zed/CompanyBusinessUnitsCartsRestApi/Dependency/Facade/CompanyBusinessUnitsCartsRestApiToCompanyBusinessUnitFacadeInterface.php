<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    public function findCompanyBusinessUnitByUuid(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitResponseTransfer;
}
