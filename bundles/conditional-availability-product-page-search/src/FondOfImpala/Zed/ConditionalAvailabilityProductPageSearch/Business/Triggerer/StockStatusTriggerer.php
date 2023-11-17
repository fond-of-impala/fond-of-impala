<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Triggerer;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface;

class StockStatusTriggerer implements StockStatusTriggererInterface
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
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface $productAbstractReader,
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
        $productConcreteIds = $this->repository->findConcreteProductIdsToTrigger();

        if (count($productConcreteIds) === 0) {
            return;
        }

        $this->productPageSearchFacade->publishProductConcretes($productConcreteIds);
        $this->productPageSearchFacade->publish(
            $this->productAbstractReader->getProductAbstractIdsByConcreteIds($productConcreteIds)
        );
    }
}
