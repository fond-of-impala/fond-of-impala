<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface ProductListsBulkRestApiToEventFacadeInterface
{
    /**
     * @param string $eventName
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return void
     */
    public function trigger(string $eventName, TransferInterface $transfer): void;
}
