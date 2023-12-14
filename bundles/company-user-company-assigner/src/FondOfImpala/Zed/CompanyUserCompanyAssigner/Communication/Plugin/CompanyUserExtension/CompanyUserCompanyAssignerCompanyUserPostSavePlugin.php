<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class CompanyUserCompanyAssignerCompanyUserPostSavePlugin extends AbstractPlugin implements CompanyUserPostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function postSave(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if (
            $companyUserTransfer === null
            || $companyUserResponseTransfer->getIsSuccessful() !== true
            || !$this->isCompanyTypeManufacturer($companyUserTransfer)
            || !$this->hasDiffCompanyUserRolesAsManufacturer($companyUserTransfer)
        ) {
            return $companyUserResponseTransfer;
        }

        $this->getFactory()
            ->getEventFacade()
            ->trigger(
                CompanyUserCompanyAssignerEvents::MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE,
                $companyUserTransfer,
            );

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    protected function isCompanyTypeManufacturer(CompanyUserTransfer $companyUserTransfer): bool
    {
        $companyTypeManufacturerTransfer = $this->getFacade()->getManufacturerCompanyType();
        $companyTypeTransfer = $this->getFacade()->getCompanyTypeByCompany(
            (new CompanyTransfer())->setIdCompany($companyUserTransfer->getFkCompany()),
        );

        return ($companyTypeTransfer->getName() === $companyTypeManufacturerTransfer->getName());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    protected function hasDiffCompanyUserRolesAsManufacturer(CompanyUserTransfer $companyUserTransfer): bool
    {
        $companyUsers = $this->getFacade()
            ->findCompanyUsersWithInconsistentCompanyRolesByManufacturerUser($companyUserTransfer);

        return (count($companyUsers) > 0);
    }
}
