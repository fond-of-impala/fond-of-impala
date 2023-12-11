<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface;

class StockStatusTrigger implements StockStatusTriggerInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
     */
    protected ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface $productPageSearchFacade;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface
     */
    protected ProductAbstractReaderInterface $productAbstractReader;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface
     */
    protected ConditionalAvailabilityProductPageSearchRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface $productAbstractReader
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface $productPageSearchFacade
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface $repository
     */
    public function __construct(
        ProductAbstractReaderInterface $productAbstractReader,
        ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface $productPageSearchFacade,
        ConditionalAvailabilityProductPageSearchRepositoryInterface $repository
    ) {
        $this->productAbstractReader = $productAbstractReader;
        $this->productPageSearchFacade = $productPageSearchFacade;
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

        $productAbstractIds = $this->productAbstractReader->getProductAbstractIdsByConcreteIds($productConcreteIds);

        $this->productPageSearchFacade->publishProductConcretes($productConcreteIds);
        $this->productPageSearchFacade->publish($productAbstractIds);
    }
}
