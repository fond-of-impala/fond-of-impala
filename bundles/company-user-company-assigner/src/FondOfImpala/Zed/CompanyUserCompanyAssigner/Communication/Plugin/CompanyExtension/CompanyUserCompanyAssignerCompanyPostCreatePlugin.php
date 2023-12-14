<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyExtension;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\CompanyExtension\Dependency\Plugin\CompanyPostCreatePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class CompanyUserCompanyAssignerCompanyPostCreatePlugin extends AbstractPlugin implements CompanyPostCreatePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function postCreate(CompanyResponseTransfer $companyResponseTransfer): CompanyResponseTransfer
    {
        return $this->getFacade()->addManufacturerUsersToCompany($companyResponseTransfer);
    }
}
