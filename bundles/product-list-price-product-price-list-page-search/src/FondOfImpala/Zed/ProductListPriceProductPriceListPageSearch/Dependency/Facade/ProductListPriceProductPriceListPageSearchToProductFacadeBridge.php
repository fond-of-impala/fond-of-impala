<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ProductListPriceProductPriceListPageSearchToProductFacadeBridge implements
    ProductListPriceProductPriceListPageSearchToProductFacadeInterface
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
     * @param array<int> $productConcreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByProductConcreteIds(array $productConcreteIds): array
    {
        return $this->productFacade->getProductAbstractIdsByProductConcreteIds($productConcreteIds);
    }
}
