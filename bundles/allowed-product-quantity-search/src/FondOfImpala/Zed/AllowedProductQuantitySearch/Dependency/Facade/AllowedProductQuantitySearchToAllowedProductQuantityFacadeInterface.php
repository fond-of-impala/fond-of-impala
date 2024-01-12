<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade;

use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

interface AllowedProductQuantitySearchToAllowedProductQuantityFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer
     */
    public function findProductAbstractAllowedQuantity(
        ProductAbstractTransfer $productAbstractTransfer
    ): AllowedProductQuantityResponseTransfer;
}
