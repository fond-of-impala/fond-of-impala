<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Listener;

use Exception;
use FondOfImpala\Shared\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorConstants;
use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacadeInterface getFacade()
 */
class CompanyUserDeleterListener extends AbstractPlugin implements EventHandlerInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     * @param $eventName
     *
     * @throws \Exception
     *
     * @return void
     */
    public function handle(TransferInterface $transfer, $eventName): void
    {
        if (
            $transfer instanceof CompanyUserIdCollectionTransfer
            && $eventName === CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER
        ) {
            try {
                $this->getFacade()->deleteCompanyUserByIds($transfer);
            } catch (Exception $exception) {
                //ToDo: maybe log here
                throw $exception;
            }
        }
    }
}
