<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

interface PriceGrouperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     * @param array $existingPricesData
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function groupPricesData(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer,
        array $existingPricesData = []
    ): PriceProductPriceListPageSearchTransfer;
}
