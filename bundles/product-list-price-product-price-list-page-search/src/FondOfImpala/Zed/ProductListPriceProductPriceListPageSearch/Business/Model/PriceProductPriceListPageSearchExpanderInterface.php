<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

interface PriceProductPriceListPageSearchExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function expandWithProductLists(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer;
}
