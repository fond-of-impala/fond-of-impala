<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class AssignManufacturerUserToNonManufacturerCompaniesListener extends AbstractPlugin implements EventHandlerInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     * @param string $eventName
     *
     * @return void
     */
    public function handle(TransferInterface $transfer, $eventName): void
    {
        if (
            !($transfer instanceof CompanyUserTransfer)
            || $eventName !== CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT
        ) {
            return;
        }

        $this->getFacade()->assignManufacturerUserNonManufacturerCompanies($transfer);
    }
}
