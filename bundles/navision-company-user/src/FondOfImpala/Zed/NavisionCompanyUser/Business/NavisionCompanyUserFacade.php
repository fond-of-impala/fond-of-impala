<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Business;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\NavisionCompanyUser\Business\NavisionCompanyUserBusinessFactory getFactory()
 */
class NavisionCompanyUserFacade extends AbstractFacade implements NavisionCompanyUserFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByUuid(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        return $this->getFactory()->createCompanyUserReader()->findCompanyUserByExternalReference($companyUserTransfer);
    }
}
