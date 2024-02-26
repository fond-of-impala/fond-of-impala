<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface OrderBudgetsBulkRestApiToEventFacadeInterface
{
    /**
     * @param string $eventName
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return void
     */
    public function trigger(string $eventName, TransferInterface $transfer): void;
}
