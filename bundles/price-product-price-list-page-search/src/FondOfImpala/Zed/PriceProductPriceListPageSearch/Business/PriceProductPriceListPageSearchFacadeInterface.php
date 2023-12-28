<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business;

interface PriceProductPriceListPageSearchFacadeInterface
{
    /**
     * Specification:
     *  - Publish price list prices for product abstracts.
     *  - Uses the given IDs of the `foi_price_product_price_list` table.
     *  - Merges created or updated prices to the existing ones.
     *
     * @api
     *
     * @param array<int> $priceProductPriceListIds
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceList(array $priceProductPriceListIds): void;

    /**
     * Specification:
     *  - Publish price list prices for product abstracts.
     *  - Uses the given fkPriceList of the `foi_price_product_price_list` table.
     *  - Merges created or updated prices to the existing ones.
     *
     * @api
     *
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceListByIdPriceList(int $idPriceList): void;

    /**
     * Specification:
     *  - Publish price list prices for product abstracts.
     *  - Uses the given fkPriceList of the `foi_price_product_price_list` table.
     *  - Merges created or updated prices to the existing ones.
     *
     * @api
     *
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishConcretePriceProductPriceListByIdPriceList(int $idPriceList): void;

    /**
     * Specification:
     *  - Publish price list prices for product abstracts.
     *  - Uses the given abstract product IDs.
     *  - Merges created or updated prices to the existing ones.
     *
     * @api
     *
     * @param array<int> $productAbstractIds
     *
     * @return void
     */
    public function publishAbstractPriceProductByByProductAbstractIds(array $productAbstractIds): void;

    /**
     * Specification:
     *  - Publish merchant relationship prices for product concretes.
     *  - Uses the given concrete product IDs.
     *  - Refreshes the prices data for product concretes for all business units and merchant relationships.
     *
     * @api
     *
     * @param array<int> $productIds
     *
     * @return void
     */
    public function publishConcretePriceProductByProductIds(array $productIds): void;

    /**
     * Specification:
     *  - Publish price list prices for products.
     *  - Uses the given IDs of the `foi_price_product_price_list` table.
     *  - Merges created or updated prices to the existing ones.
     *
     * @api
     *
     * @param array<int> $priceProductPriceListIds
     *
     * @return void
     */
    public function publishConcretePriceProductPriceList(array $priceProductPriceListIds): void;
}
