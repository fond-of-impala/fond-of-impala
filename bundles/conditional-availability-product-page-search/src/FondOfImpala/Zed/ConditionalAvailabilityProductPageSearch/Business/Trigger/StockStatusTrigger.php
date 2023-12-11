<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface;

class StockStatusTrigger implements StockStatusTriggerInterface
{
    protected ProductAbstractReaderInterface $productAbstractReader;

    protected ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade;

    protected ConditionalAvailabilityProductPageSearchRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface $productAbstractReader
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface $repository
     */
    public function __construct(
        ProductAbstractReaderInterface $productAbstractReader,
        ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade,
        ConditionalAvailabilityProductPageSearchRepositoryInterface $repository
    ) {
        $this->productAbstractReader = $productAbstractReader;
        $this->eventBehaviorFacade = $eventBehaviorFacade;
        $this->repository = $repository;
    }

    /**
     * @return void
     */
    public function trigger(): void
    {
        $productConcreteIds = $this->repository->findProductConcreteIdsToTrigger();

        $this->triggerByProductConcreteIds($productConcreteIds);
    }

    /**
     * @return void
     */
    public function triggerDelta(): void
    {
        $productConcreteIds = $this->repository->findProductConcreteIdsForDeltaTrigger();

        $this->triggerByProductConcreteIds($productConcreteIds);
    }

    /**
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    protected function triggerByProductConcreteIds(array $productConcreteIds): void
    {
        if (count($productConcreteIds) === 0) {
            return;
        }

        $this->eventBehaviorFacade->executeResolvedPluginsBySources(['product_concrete'], $productConcreteIds);

        $productAbstractIds = $this->productAbstractReader->getProductAbstractIdsByConcreteIds($productConcreteIds);

        if (count($productAbstractIds) === 0) {
            return;
        }

        $this->eventBehaviorFacade->executeResolvedPluginsBySources(['product_abstract'], $productAbstractIds);
    }
}
