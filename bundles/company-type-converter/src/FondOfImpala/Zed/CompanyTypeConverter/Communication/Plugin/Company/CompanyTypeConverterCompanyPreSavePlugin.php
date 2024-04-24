<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Communication\Plugin\Company;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\ResponseMessageTransfer;
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
     * - Plugin is triggered before company object is saved.
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

        if (!$this->getFacade()->isTypeConvertable($companyTransfer, $currentCompanyTransfer)) {
            $message = (new ResponseMessageTransfer())
                ->setText(sprintf('The current company type key "%s" is part of the non convertible role type keys and could not been converted!', $currentCompanyTransfer->getCompanyType()->getName()));

            return $companyResponseTransfer
                ->setIsSuccessful(false)
                ->addMessage($message);
        }

        $companyTransfer->setIsCompanyTypeModified(true);
        $companyTransfer->setFkOldCompanyType($currentCompanyTransfer->getFkCompanyType());

        return $companyResponseTransfer;
    }
}
