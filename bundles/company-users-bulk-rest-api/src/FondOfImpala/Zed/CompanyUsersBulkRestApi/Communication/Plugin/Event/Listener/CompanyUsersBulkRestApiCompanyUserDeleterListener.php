<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Listener;

use FondOfImpala\Shared\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiConstants;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacadeInterface getFacade()
 */
class CompanyUsersBulkRestApiCompanyUserDeleterListener extends AbstractPlugin implements EventHandlerInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     * @param $eventName
     *
     * @return void
     */
    public function handle(TransferInterface $transfer, $eventName): void
    {
        if (
            !($transfer instanceof RestCompanyUsersBulkItemCollectionTransfer)
            || $eventName !== CompanyUsersBulkRestApiConstants::BULK_UNASSIGN
        ) {
            return;
        }

        $this->getFacade()->deleteCompanyUserBulkMode($transfer);
    }
}
