<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Reader;

use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface;

class ProductListReader implements ProductListReaderInterface
{
    /**
     * @var array<int, array<int>>
     */
    protected static array $whitelistIdsPerIdProduct = [];

    /**
     * @var array<int, array<int>>
     */
    protected static array $blacklistIdsPerIdProduct = [];

    protected ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface $productListFacade;

    /**
     * @param \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface $productListFacade
     */
    public function __construct(
        ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface $productListFacade
    ) {
        $this->productListFacade = $productListFacade;
    }

    /**
     * @param int $idProduct
     *
     * @return array<int>
     */
    public function getBlacklistIdsByIdProduct(int $idProduct): array
    {
        if (isset(static::$blacklistIdsPerIdProduct[$idProduct])) {
            return static::$blacklistIdsPerIdProduct[$idProduct];
        }

        static::$blacklistIdsPerIdProduct[$idProduct] = $this->productListFacade->getProductBlacklistIdsByIdProduct(
            $idProduct,
        );

        return static::$blacklistIdsPerIdProduct[$idProduct];
    }

    /**
     * @inheritDoc
     */
    public function getWhitelistIdsByIdProduct(int $idProduct): array
    {
        if (isset(static::$whitelistIdsPerIdProduct[$idProduct])) {
            return static::$whitelistIdsPerIdProduct[$idProduct];
        }

        static::$whitelistIdsPerIdProduct[$idProduct] = $this->productListFacade->getProductWhitelistIdsByIdProduct(
            $idProduct,
        );

        return static::$whitelistIdsPerIdProduct[$idProduct];
    }
}
