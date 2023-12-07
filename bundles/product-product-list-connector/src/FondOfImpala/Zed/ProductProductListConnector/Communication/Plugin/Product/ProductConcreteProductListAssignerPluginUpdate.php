<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Communication\Plugin\Product;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\Plugin\ProductConcretePluginUpdateInterface;

/**
 * @method \FondOfImpala\Zed\ProductProductListConnector\Business\ProductProductListConnectorFacadeInterface getFacade()
 */
class ProductConcreteProductListAssignerPluginUpdate extends AbstractPlugin implements ProductConcretePluginUpdateInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function update(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        $this->getFacade()->updateProductToProductLists($productConcreteTransfer);

        return $productConcreteTransfer;
    }
}
