<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface;

class ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeBridge implements
    ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeInterface
{
    protected PriceProductPriceListPageSearchFacadeInterface $priceProductPriceListPageSearchFacade;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface $priceProductPriceListPageSearchFacade
     */
    public function __construct(PriceProductPriceListPageSearchFacadeInterface $priceProductPriceListPageSearchFacade)
    {
        $this->priceProductPriceListPageSearchFacade = $priceProductPriceListPageSearchFacade;
    }

    /**
     * @param array<int> $productAbstractIds
     *
     * @return void
     */
    public function publishAbstractPriceProductByByProductAbstractIds(array $productAbstractIds): void
    {
        $this->priceProductPriceListPageSearchFacade->publishAbstractPriceProductByByProductAbstractIds(
            $productAbstractIds,
        );
    }

    /**
     * @param array<int> $productIds
     *
     * @return void
     */
    public function publishConcretePriceProductByProductIds(array $productIds): void
    {
        $this->priceProductPriceListPageSearchFacade->publishConcretePriceProductByProductIds(
            $productIds,
        );
    }
}
