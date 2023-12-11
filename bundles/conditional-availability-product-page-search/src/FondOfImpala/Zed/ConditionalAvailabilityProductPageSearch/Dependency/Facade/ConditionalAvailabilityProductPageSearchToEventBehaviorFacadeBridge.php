<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridge implements ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface
{
    protected EventBehaviorFacadeInterface $facade;

    /**
     * @param \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface $facade
     */
    public function __construct(EventBehaviorFacadeInterface $facade)
    {
        $this->facade = $facade;
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
        $this->facade->executeResolvedPluginsBySources($resources, $ids, $resourcePublisherPlugins);
    }
}
