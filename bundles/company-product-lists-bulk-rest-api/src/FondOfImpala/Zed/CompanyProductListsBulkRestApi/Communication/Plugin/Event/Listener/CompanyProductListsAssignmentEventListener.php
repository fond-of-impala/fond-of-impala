<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Communication\Plugin\Event\Listener;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CompanyProductListsAssignmentEventListener extends AbstractPlugin implements EventHandlerInterface
{

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     * @param string $eventName
     *
     * @return void
     */
    public function handle(TransferInterface $transfer, $eventName)
    {
        if (
            !($transfer instanceof RestProductListsBulkRequestAssignmentTransfer)
            || $eventName !== 'ProductListsBulkRestApiEvents::ASSIGNMENT_PROCESS'
        ) {
            return;
        }
    }


}
