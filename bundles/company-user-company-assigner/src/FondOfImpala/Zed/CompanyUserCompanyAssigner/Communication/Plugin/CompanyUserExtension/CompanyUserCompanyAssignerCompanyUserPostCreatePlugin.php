<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class CompanyUserCompanyAssignerCompanyUserPostCreatePlugin extends AbstractPlugin implements CompanyUserPostCreatePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function postCreate(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if (
            $companyUserTransfer === null
            || $companyUserTransfer->getSkipAssignmentToNonManufacturerCompanies() === true
            || $companyUserResponseTransfer->getIsSuccessful() !== true
        ) {
            return $companyUserResponseTransfer;
        }

        $this->getFactory()
            ->getEventFacade()
            ->trigger(
                CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT,
                $companyUserTransfer,
            );

        return $companyUserResponseTransfer;
    }
}
