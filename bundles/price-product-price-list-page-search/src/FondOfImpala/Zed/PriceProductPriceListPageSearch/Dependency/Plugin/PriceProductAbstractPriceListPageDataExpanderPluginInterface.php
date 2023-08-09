<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Plugin;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

interface PriceProductAbstractPriceListPageDataExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands the provided PriceProductPriceListPageSearchTransfer transfer object's data by reference.
     *
     * @api
     *
     * @param array $data
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return void
     */
    public function expand(
        array $data,
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): void;
}
