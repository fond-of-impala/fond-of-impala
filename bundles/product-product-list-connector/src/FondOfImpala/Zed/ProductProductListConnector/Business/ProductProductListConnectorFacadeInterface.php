<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business;

use Generated\Shared\Transfer\ProductConcreteTransfer;

interface ProductProductListConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function addProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function updateProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void;
}
