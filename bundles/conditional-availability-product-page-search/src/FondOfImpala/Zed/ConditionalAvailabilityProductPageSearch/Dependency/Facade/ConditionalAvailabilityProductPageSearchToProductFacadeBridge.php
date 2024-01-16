<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ConditionalAvailabilityProductPageSearchToProductFacadeBridge implements ConditionalAvailabilityProductPageSearchToProductFacadeInterface
{
    protected ProductFacadeInterface $productFacade;

    /**
     * @param \Spryker\Zed\Product\Business\ProductFacadeInterface $productFacade
     */
    public function __construct(ProductFacadeInterface $productFacade)
    {
        $this->productFacade = $productFacade;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $productConcreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByProductConcreteIds(array $productConcreteIds): array
    {
        return $this->productFacade->getProductAbstractIdsByProductConcreteIds($productConcreteIds);
    }
}
