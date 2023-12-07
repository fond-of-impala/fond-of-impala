<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Communication\Plugin\Product;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductConcreteCreatePluginInterface;

/**
 * @method \FondOfImpala\Zed\ProductProductListConnector\Business\ProductProductListConnectorFacadeInterface getFacade()
 */
class ProductConcreteProductListAssignerAfterCreatePlugin extends AbstractPlugin implements ProductConcreteCreatePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function create(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        $this->getFacade()->addProductToProductLists($productConcreteTransfer);

        return $productConcreteTransfer;
    }
}
