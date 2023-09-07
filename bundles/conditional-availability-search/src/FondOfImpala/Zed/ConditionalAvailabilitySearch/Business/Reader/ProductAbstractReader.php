<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Reader;

use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeInterface;

class ProductAbstractReader implements ProductAbstractReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeInterface $productFacade
     */
    public function __construct(ConditionalAvailabilitySearchToProductFacadeInterface $productFacade) {
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
