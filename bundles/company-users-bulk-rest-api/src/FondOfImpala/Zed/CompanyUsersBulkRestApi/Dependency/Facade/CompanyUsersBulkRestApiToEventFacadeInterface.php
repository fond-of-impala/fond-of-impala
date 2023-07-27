<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface CompanyUsersBulkRestApiToEventFacadeInterface
{
    /**
     * @param string $eventName
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return void
     */
    public function trigger(string $eventName, TransferInterface $transfer);
}
