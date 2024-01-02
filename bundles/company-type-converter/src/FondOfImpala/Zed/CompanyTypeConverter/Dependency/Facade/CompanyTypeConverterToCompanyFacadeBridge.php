<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;

class CompanyTypeConverterToCompanyFacadeBridge implements CompanyTypeConverterToCompanyFacadeInterface
{
    protected CompanyFacadeInterface $companyFacade;

    /**
     * @param \Spryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     */
    public function __construct(CompanyFacadeInterface $companyFacade)
    {
        $this->companyFacade = $companyFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function getCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->companyFacade->getCompanyById($companyTransfer);
    }
}
