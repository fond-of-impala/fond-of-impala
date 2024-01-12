<?php

namespace FondOfImpala\Zed\ProductManagement\Dependency\Plugin;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductAbstractFormTransferMapperExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands ProductAbstractTransfer with submitted data
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param array $formData
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function map(ProductAbstractTransfer $productAbstractTransfer, array $formData): ProductAbstractTransfer;
}
