<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;

class ProductAbstractReader implements ProductAbstractReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade
     */
    public function __construct(ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacade)
    {
        $this->productFacade = $productFacade;
    }

    /**
     * @param array<int> $concreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByConcreteIds(array $concreteIds): array
    {
        return $this->productFacade->getProductAbstractIdsByProductConcreteIds($concreteIds);
    }
}
