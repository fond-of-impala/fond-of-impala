<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use Generated\Shared\Transfer\ProductPageLoadTransfer;

interface ProductPageLoadExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expand(ProductPageLoadTransfer $productPageLoadTransfer): ProductPageLoadTransfer;
}
