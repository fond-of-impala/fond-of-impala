<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Expander;

use Generated\Shared\Transfer\ProductPageSearchTransfer;

interface ProductPageDataExpanderInterface
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
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): ProductPageSearchTransfer;
}
