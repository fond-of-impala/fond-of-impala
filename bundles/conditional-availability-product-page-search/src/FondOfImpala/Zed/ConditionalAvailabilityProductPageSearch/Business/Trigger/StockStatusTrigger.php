<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface;

class StockStatusTrigger implements StockStatusTriggerInterface
{
    protected ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade;

    protected ConditionalAvailabilityProductPageSearchRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface $repository
     */
    public function __construct(
        ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade,
        ConditionalAvailabilityProductPageSearchRepositoryInterface $repository
    ) {
        $this->eventBehaviorFacade = $eventBehaviorFacade;
        $this->repository = $repository;
    }

    /**
     * @return void
     */
    public function trigger(): void
    {
        $productAbstractIds = $this->repository->findProductAbstractIdsToTrigger();

        $this->triggerByProductAbstractIds($productAbstractIds);
    }

    /**
     * @return void
     */
    public function triggerDelta(): void
    {
        $productAbstractIds = $this->repository->findProductAbstractIdsForDeltaTrigger();

        $this->triggerByProductAbstractIds($productAbstractIds);
    }

    /**
     * @param array<int> $productAbstractIds
     *
     * @return void
     */
    protected function triggerByProductAbstractIds(array $productAbstractIds): void
    {
        if (count($productAbstractIds) === 0) {
            return;
        }

        $this->eventBehaviorFacade->executeResolvedPluginsBySources(['product_abstract'], $productAbstractIds);
    }
}
