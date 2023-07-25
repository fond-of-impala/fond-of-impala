<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Communication\Plugin\Company;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\CompanyExtension\Dependency\Plugin\CompanyPreSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig getConfig()
 */
class CompanyTypeConverterCompanyPreSavePlugin extends AbstractPlugin implements CompanyPreSavePluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered after company object is saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function preSaveValidation(CompanyResponseTransfer $companyResponseTransfer): CompanyResponseTransfer
    {
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if (
            $companyTransfer === null
            || $companyTransfer->getFkCompanyType() === null
            || $companyTransfer->getIdCompany() === null
        ) {
            return $companyResponseTransfer;
        }

        $currentCompanyTransfer = $this->getFacade()->findCompanyById($companyTransfer);

        if ($currentCompanyTransfer->getFkCompanyType() === $companyTransfer->getFkCompanyType()) {
            return $companyResponseTransfer;
        }

        $companyTransfer->setIsCompanyTypeModified(true);
        $companyTransfer->setFkOldCompanyType($currentCompanyTransfer->getFkCompanyType());

        return $companyResponseTransfer;
    }
}
