<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyReader implements CompanyReaderInterface
{
    protected CompanyTypeConverterToCompanyFacadeInterface $companyFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface $companyFacade
     */
    public function __construct(CompanyTypeConverterToCompanyFacadeInterface $companyFacade)
    {
        $this->companyFacade = $companyFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function findCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->companyFacade->getCompanyById($companyTransfer);
    }
}
