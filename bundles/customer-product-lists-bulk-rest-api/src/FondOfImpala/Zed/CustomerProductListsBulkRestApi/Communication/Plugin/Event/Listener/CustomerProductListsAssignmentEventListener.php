<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Communication\Plugin\Event\Listener;

use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\ProductListsBulkRestApiEvents;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\CustomerProductListsBulkRestApiFacadeInterface getFacade()
 */
class CustomerProductListsAssignmentEventListener extends AbstractPlugin implements EventHandlerInterface
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
            !($transfer instanceof RestProductListsBulkRequestAssignmentTransfer)
            || $eventName !== ProductListsBulkRestApiEvents::ASSIGNMENT_PROCESS
        ) {
            return;
        }

        $this->getFacade()->persistCustomerProductListRelation($transfer);
    }
}
