<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Business\Model;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductAbstractAllowedQuantityWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function persist(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer;
}
