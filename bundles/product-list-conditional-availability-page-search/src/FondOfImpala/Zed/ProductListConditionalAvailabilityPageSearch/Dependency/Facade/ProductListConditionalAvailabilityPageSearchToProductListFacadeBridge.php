<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge implements ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface
{
    protected ProductListFacadeInterface $productListFacade;

    /**
     * @param \Spryker\Zed\ProductList\Business\ProductListFacadeInterface $productListFacade
     */
    public function __construct(ProductListFacadeInterface $productListFacade)
    {
        $this->productListFacade = $productListFacade;
    }

    /**
     * @param int $idProduct
     *
     * @return array<int>
     */
    public function getProductWhitelistIdsByIdProduct(int $idProduct): array
    {
        return $this->productListFacade->getProductWhitelistIdsByIdProduct($idProduct);
    }

    /**
     * @param int $idProduct
     *
     * @return array<int>
     */
    public function getProductBlacklistIdsByIdProduct(int $idProduct): array
    {
        return $this->productListFacade->getProductBlacklistIdsByIdProduct($idProduct);
    }
}
