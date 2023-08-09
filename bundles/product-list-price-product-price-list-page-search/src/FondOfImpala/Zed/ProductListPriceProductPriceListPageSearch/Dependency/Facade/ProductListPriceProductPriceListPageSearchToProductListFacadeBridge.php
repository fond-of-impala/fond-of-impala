<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;

class ProductListPriceProductPriceListPageSearchToProductListFacadeBridge implements ProductListPriceProductPriceListPageSearchToProductListFacadeInterface
{
    /**
     * @var \Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    protected $productListFacade;

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
     * @return int[]
     */
    public function getProductBlacklistIdsByIdProduct(int $idProduct): array
    {
        return $this->productListFacade->getProductBlacklistIdsByIdProduct($idProduct);
    }

    /**
     * @param int $idProduct
     *
     * @return int[]
     */
    public function getProductWhitelistIdsByIdProduct(int $idProduct): array
    {
        return $this->productListFacade->getProductWhitelistIdsByIdProduct($idProduct);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return int[]
     */
    public function getProductBlacklistIdsByIdProductAbstract(int $idProductAbstract): array
    {
        return $this->productListFacade->getProductBlacklistIdsByIdProductAbstract($idProductAbstract);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return int[]
     */
    public function getProductWhitelistIdsByIdProductAbstract(int $idProductAbstract): array
    {
        return $this->productListFacade->getProductWhitelistIdsByIdProductAbstract($idProductAbstract);
    }
}
