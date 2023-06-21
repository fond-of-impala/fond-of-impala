<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade;

use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge implements ConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
{
    /**
     * @var \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacade;

    /**
     * @param \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface $eventBehaviorFacadeFacade
     */
    public function __construct(EventBehaviorFacadeInterface $eventBehaviorFacadeFacade)
    {
        $this->eventBehaviorFacade = $eventBehaviorFacadeFacade;
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventTransfers
     *
     * @return array
     */
    public function getEventTransferIds(array $eventTransfers): array
    {
        return $this->eventBehaviorFacade->getEventTransferIds($eventTransfers);
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventTransfers
     * @param string $foreignKeyColumnName
     *
     * @return array
     */
    public function getEventTransferForeignKeys(array $eventTransfers, string $foreignKeyColumnName): array
    {
        return $this->eventBehaviorFacade->getEventTransferForeignKeys(
            $eventTransfers,
            $foreignKeyColumnName,
        );
    }
}
