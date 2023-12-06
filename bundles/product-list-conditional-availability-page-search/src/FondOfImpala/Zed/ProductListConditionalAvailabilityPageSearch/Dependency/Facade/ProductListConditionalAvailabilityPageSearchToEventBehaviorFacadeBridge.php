<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge implements ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
{
    protected EventBehaviorFacadeInterface $eventBehaviorFacade;

    /**
     * @param \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface $eventBehaviorFacade
     */
    public function __construct(EventBehaviorFacadeInterface $eventBehaviorFacade)
    {
        $this->eventBehaviorFacade = $eventBehaviorFacade;
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventTransfers
     * @param string $foreignKeyColumnName
     *
     * @return array
     */
    public function getEventTransferForeignKeys(array $eventTransfers, $foreignKeyColumnName): array
    {
        return $this->eventBehaviorFacade->getEventTransferForeignKeys($eventTransfers, $foreignKeyColumnName);
    }

    /**
     * @param array<string> $resources
     * @param array<int> $ids
     * @param array<\Spryker\Zed\EventBehavior\Dependency\Plugin\EventResourcePluginInterface> $resourcePublisherPlugins
     *
     * @return void
     */
    public function executeResolvedPluginsBySources(
        array $resources,
        array $ids = [],
        array $resourcePublisherPlugins = []
    ): void {
        $this->eventBehaviorFacade->executeResolvedPluginsBySources(
            $resources,
            $ids,
            $resourcePublisherPlugins,
        );
    }
}
