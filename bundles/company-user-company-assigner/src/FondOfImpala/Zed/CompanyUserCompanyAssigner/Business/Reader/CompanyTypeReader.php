<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeReader implements CompanyTypeReaderInterface
{
    protected CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
    ) {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getManufacturerCompanyType(): CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getManufacturerCompanyType();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getByCompany(CompanyTransfer $companyTransfer): CompanyTypeTransfer
    {
        return $this->companyTypeFacade->findCompanyTypeByIdCompany($companyTransfer);
    }
}
