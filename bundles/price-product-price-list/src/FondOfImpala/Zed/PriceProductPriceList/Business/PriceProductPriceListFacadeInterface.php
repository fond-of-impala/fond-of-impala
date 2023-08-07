<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business;

use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;

interface PriceProductPriceListFacadeInterface
{
    /**
     * Specification:
     *  - Sets price dimension type as price list.
     *  - Sets price dimension name using the price list name.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceProductDimensionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    public function expandPriceProductDimension(PriceProductDimensionTransfer $priceProductDimensionTransfer): PriceProductDimensionTransfer;

    /**
     * Specification:
     *  - For BC reasons: Creates spy_price_product_store entry if does not exist.
     *  - Saves connection between spy_price_product_store and spy_price_product_price_list.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function savePriceProductPriceList(PriceProductTransfer $priceProductTransfer): PriceProductTransfer;

    /**
     * Specification:
     *  - Deletes connection records between spy_price_product_store and price_list. by idPriceProductStore
     *
     * @api
     *
     * @param int $idPriceProductStore
     *
     * @return void
     */
    public function deletePriceProductPriceListByIdPriceProductStore(int $idPriceProductStore): void;
}
