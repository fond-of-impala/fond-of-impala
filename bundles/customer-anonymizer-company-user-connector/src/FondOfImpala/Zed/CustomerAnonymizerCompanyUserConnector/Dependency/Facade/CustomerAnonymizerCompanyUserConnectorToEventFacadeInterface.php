<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface
{
    /**
     * @param string $eventName
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return void
     */
    public function trigger(string $eventName, TransferInterface $transfer);
}
