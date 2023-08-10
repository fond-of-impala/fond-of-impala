<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

interface ProductListPriceProductPriceListPageSearchFacadeInterface
{
    /**
     * Specification:
     *  - Expands PriceProductPriceListPageSearchTransfer with product lists data and returns the modified object.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function expandPriceProductAbstractPriceListPageSearchWithProductLists(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer;

    /**
     * Specification:
     *  - Expands PriceProductPriceListPageSearchTransfer with product lists data and returns the modified object.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function expandPriceProductConcretePriceListPageSearchWithProductLists(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer;
}
