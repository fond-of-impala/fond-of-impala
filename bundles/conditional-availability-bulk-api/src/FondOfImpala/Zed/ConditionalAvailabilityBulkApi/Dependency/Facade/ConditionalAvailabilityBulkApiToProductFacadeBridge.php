<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade;

use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ConditionalAvailabilityBulkApiToProductFacadeBridge implements
    ConditionalAvailabilityBulkApiToProductFacadeInterface
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
     * @param array<string> $skus
     *
     * @return array<int>
     */
    public function getProductConcreteIdsByConcreteSkus(array $skus): array
    {
        return $this->productFacade->getProductConcreteIdsByConcreteSkus($skus);
    }
}
