<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class CompanyUserCompanyAssignerToEventFacadeBridge implements CompanyUserCompanyAssignerToEventFacadeInterface
{
    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected $eventFacade;

    /**
     * @param \Spryker\Zed\Event\Business\EventFacadeInterface $eventFacade
     */
    public function __construct(EventFacadeInterface $eventFacade)
    {
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param string $eventName
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return void
     */
    public function trigger(string $eventName, TransferInterface $transfer): void
    {
        $this->eventFacade->trigger($eventName, $transfer);
    }
}
