<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyTypeConverter\Persistence\CompanyTypeConverterRepositoryInterface getRepository()
 */
class CompanyTypeConverterFacade extends AbstractFacade implements CompanyTypeConverterFacadeInterface
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
    public function convertCompanyType(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->getFactory()->createCompanyTypeConverter()->convertCompanyType($companyTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function findCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->getFactory()->createCompanyReader()->findCompanyById($companyTransfer);
    }
}
