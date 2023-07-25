<?php

namespace FondOfImpala\Zed\CompanyType\Communication\Plugin\CompanyExtension;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\CompanyExtension\Dependency\Plugin\CompanyPreSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyType\CompanyTypeConfig getConfig()
 */
class CompanyTypeCompanyPreSavePlugin extends AbstractPlugin implements CompanyPreSavePluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function preSaveValidation(CompanyResponseTransfer $companyResponseTransfer): CompanyResponseTransfer
    {
        return $this->getFacade()->assignDefaultCompanyTypeToNewCompany($companyResponseTransfer);
    }
}
