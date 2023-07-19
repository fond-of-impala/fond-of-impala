<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade;

use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class CustomerAnonymizerCompanyUserConnectorToEventFacadeBridge implements CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface
{
    protected EventFacadeInterface $facade;

    /**
     * @param \Spryker\Zed\Event\Business\EventFacadeInterface $eventFacade
     */
    public function __construct(EventFacadeInterface $eventFacade)
    {
        $this->facade = $eventFacade;
    }

    /**
     * @param string $eventName
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return void
     */
    public function trigger(string $eventName, TransferInterface $transfer): void
    {
        $this->facade->trigger($eventName, $transfer);
    }
}
