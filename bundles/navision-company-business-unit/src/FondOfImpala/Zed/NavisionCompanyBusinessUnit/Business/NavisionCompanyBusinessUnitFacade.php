<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\NavisionCompanyBusinessUnitBusinessFactory getFactory()
 */
class NavisionCompanyBusinessUnitFacade extends AbstractFacade implements NavisionCompanyBusinessUnitFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    public function findCompanyBusinessUnitByUuid(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitResponseTransfer {
        return $this->getFactory()->createCompanyBusinessUnitReader()
            ->findCompanyBusinessUnitByExternalReference($companyBusinessUnitTransfer);
    }
}
