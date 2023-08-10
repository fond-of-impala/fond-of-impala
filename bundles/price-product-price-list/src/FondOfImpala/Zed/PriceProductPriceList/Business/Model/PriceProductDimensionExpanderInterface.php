<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business\Model;

use Generated\Shared\Transfer\PriceProductDimensionTransfer;

interface PriceProductDimensionExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceProductDimensionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    public function expand(PriceProductDimensionTransfer $priceProductDimensionTransfer): PriceProductDimensionTransfer;
}
