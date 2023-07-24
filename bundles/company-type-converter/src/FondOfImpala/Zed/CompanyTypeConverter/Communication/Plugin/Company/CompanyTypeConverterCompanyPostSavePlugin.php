<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Communication\Plugin\Company;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\CompanyExtension\Dependency\Plugin\CompanyPostSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig getConfig()
 */
class CompanyTypeConverterCompanyPostSavePlugin extends AbstractPlugin implements CompanyPostSavePluginInterface
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
    public function postSave(CompanyResponseTransfer $companyResponseTransfer): CompanyResponseTransfer
    {
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if ($companyTransfer === null || $companyTransfer->getFkCompanyType() === null) {
            return $companyResponseTransfer;
        }

        if (
            $companyTransfer->getIsCompanyTypeModified() === null
            || $companyTransfer->getIsCompanyTypeModified() === false
        ) {
            return $companyResponseTransfer;
        }

        return $this->getFacade()->convertCompanyType($companyTransfer);
    }
}
