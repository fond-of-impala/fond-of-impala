<?php

namespace FondOfImpala\Zed\NavisionCompany\Communication\Plugin\CompanyExtension;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\CompanyExtension\Dependency\Plugin\CompanyPreSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\NavisionCompany\NavisionCompanyConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompany\Business\NavisionCompanyFacadeInterface getFacade()
 */
class IsBlockedCompanyPreSavePlugin extends AbstractPlugin implements CompanyPreSavePluginInterface
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
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if ($companyTransfer === null) {
            return $companyResponseTransfer;
        }

        $isBlocked = $companyTransfer->getBlockedFor() === null || $companyTransfer->getBlockedFor() !== 'none';

        $companyTransfer->setIsBlocked($isBlocked);

        return $companyResponseTransfer;
    }
}
