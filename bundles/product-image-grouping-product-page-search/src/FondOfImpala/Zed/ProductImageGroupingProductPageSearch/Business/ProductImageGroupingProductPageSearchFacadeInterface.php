<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business;

use Generated\Shared\Transfer\ProductPageSearchTransfer;

interface ProductImageGroupingProductPageSearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageSearchTransfer
     */
    public function groupProductImageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): ProductPageSearchTransfer;
}
