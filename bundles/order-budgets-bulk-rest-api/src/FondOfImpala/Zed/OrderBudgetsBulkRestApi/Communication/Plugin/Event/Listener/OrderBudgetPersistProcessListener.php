<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\Event\Listener;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\OrderBudgetsBulkRestApiEvents;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\OrderBudgetsBulkRestApiFacadeInterface getFacade()
 */
class OrderBudgetPersistProcessListener extends AbstractPlugin implements EventHandlerInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     * @param string $eventName
     *
     * @return void
     */
    public function handle(TransferInterface $transfer, $eventName): void
    {
        if ($eventName !== OrderBudgetsBulkRestApiEvents::PERSIST_PROCESS) {
            return;
        }

        if (!($transfer instanceof RestOrderBudgetsBulkRequestOrderBudgetTransfer)) {
            return;
        }

        $this->getFacade()->persistOrderBudget($transfer);
    }
}
