<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ProductProductListConnector\Business\ProductProductListConnectorBusinessFactory getFactory()
 */
class ProductProductListConnectorFacade extends AbstractFacade implements ProductProductListConnectorFacadeInterface
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
