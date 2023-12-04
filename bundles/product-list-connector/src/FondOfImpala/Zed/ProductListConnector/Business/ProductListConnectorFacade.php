<?php

namespace FondOfImpala\Zed\ProductListConnector\Business;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ProductListConnector\Business\ProductListConnectorBusinessFactory getFactory()
 */
class ProductListConnectorFacade extends AbstractFacade implements ProductListConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function addProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $this->getFactory()->createProductListManager()->addProductToProductLists($productConcreteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function updateProductToProductLists(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $this->getFactory()->createProductListManager()->updateProductToProductLists($productConcreteTransfer);
    }
}
