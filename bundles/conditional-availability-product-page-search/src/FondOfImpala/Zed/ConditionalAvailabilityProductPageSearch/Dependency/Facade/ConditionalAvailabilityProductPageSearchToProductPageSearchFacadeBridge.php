<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface;

class ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeBridge implements ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
{
    protected ProductPageSearchFacadeInterface $productPageSearchFacade;

    /**
     * @param \Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface $productPageSearchFacade
     */
    public function __construct(ProductPageSearchFacadeInterface $productPageSearchFacade)
    {
        $this->productPageSearchFacade = $productPageSearchFacade;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $productAbstractIds
     *
     * @return void
     */
    public function publish(array $productAbstractIds): void
    {
        $this->productPageSearchFacade->publish($productAbstractIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    public function publishProductConcretes(array $productConcreteIds): void
    {
        $this->productPageSearchFacade->publishProductConcretes($productConcreteIds);
    }
}
