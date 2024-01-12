<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Communication\Plugin\Product;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginUpdateInterface;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\AllowedProductQuantityConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface getFacade()
 */
class AllowedQuantityProductAbstractAfterUpdatePlugin extends AbstractPlugin implements ProductAbstractPluginUpdateInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @see \Spryker\Zed\Product\ProductDependencyProvider
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function update(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $this->getFacade()->persistProductAbstractAllowedQuantity($productAbstractTransfer);
    }
}
