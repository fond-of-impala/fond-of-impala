<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyReader implements CompanyReaderInterface
{
    protected CompanyTypeConverterToCompanyFacadeInterface $companyFacade;

    protected CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface $companyFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(
        CompanyTypeConverterToCompanyFacadeInterface $companyFacade,
        CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade
    ) {
        $this->companyFacade = $companyFacade;
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function findCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        $companyTransfer = $this->companyFacade->getCompanyById($companyTransfer);

        $companyTypeResponseTransfer = null;
        if ($companyTransfer->getFkCompanyType() !== null && $companyTransfer->getCompanyType() === null) {
            $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType());
            $companyTypeResponseTransfer = $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);
        }

        if ($companyTypeResponseTransfer === null || $companyTypeResponseTransfer->getIsSuccessful() !== true) {
            return $companyTransfer;
        }

        return $companyTransfer->setCompanyType($companyTypeResponseTransfer->getCompanyTypeTransfer());
    }
}
