<?php

namespace FondOfImpala\Zed\NavisionCompany\Business;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\NavisionCompany\Business\NavisionCompanyBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepositoryInterface getRepository()
 */
class NavisionCompanyFacade extends AbstractFacade implements NavisionCompanyFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByExternalReference(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->getFactory()->createCompanyReader()->findCompanyByExternalReference($companyTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByDebtorNumber(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->getFactory()->createCompanyReader()->findCompanyByDebtorNumber($companyTransfer);
    }
}
