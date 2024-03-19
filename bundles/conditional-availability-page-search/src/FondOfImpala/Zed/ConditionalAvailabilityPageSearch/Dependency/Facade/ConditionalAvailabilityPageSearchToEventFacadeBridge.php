<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade;

use Spryker\Zed\Event\Business\EventFacadeInterface;

class ConditionalAvailabilityPageSearchToEventFacadeBridge implements ConditionalAvailabilityPageSearchToEventFacadeInterface
{
    protected EventFacadeInterface $eventFacade;

    /**
     * @param \Spryker\Zed\Event\Business\EventFacadeInterface $eventFacade
     */
    public function __construct(EventFacadeInterface $eventFacade)
    {
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param array<\Generated\Shared\Transfer\QueueReceiveMessageTransfer> $queueMessageTransfers
     *
     * @return array<\Generated\Shared\Transfer\QueueReceiveMessageTransfer>
     */
    public function processEnqueuedMessages(array $queueMessageTransfers): array
    {
        return $this->eventFacade->processEnqueuedMessages($queueMessageTransfers);
    }

    /**
     * @param array<\Generated\Shared\Transfer\QueueReceiveMessageTransfer> $queueMessageTransfers
     *
     * @return array<\Generated\Shared\Transfer\QueueReceiveMessageTransfer>
     */
    public function forwardMessages(array $queueMessageTransfers): array
    {
        return $this->eventFacade->forwardMessages($queueMessageTransfers);
    }
}
