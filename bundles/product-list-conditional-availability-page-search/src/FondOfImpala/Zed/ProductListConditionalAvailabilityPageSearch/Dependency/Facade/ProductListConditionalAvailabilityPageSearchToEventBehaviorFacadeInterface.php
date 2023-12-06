<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

interface ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventTransfers
     * @param string $foreignKeyColumnName
     *
     * @return array
     */
    public function getEventTransferForeignKeys(array $eventTransfers, $foreignKeyColumnName): array;

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
    ): void;
}
