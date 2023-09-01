<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

use Spryker\Zed\Product\Business\ProductFacadeInterface;

class PriceListApiToProductFacadeBridge implements PriceListApiToProductFacadeInterface
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
