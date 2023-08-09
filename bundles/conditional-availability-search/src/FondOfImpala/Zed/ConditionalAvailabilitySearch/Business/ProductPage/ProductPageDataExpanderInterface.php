<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage;

use Generated\Shared\Transfer\ProductPageLoadTransfer;

interface ProductPageDataExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $productPageLoadTransfer): ProductPageLoadTransfer;
}
