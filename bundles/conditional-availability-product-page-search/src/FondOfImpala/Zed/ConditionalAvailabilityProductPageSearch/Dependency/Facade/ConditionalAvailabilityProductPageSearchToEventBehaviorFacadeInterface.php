<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

interface ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface
{
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
