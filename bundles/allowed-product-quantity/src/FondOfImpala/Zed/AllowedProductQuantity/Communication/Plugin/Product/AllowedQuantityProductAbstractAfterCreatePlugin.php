<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Communication\Plugin\Product;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginCreateInterface;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\AllowedProductQuantityConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface getFacade()
 */
class AllowedQuantityProductAbstractAfterCreatePlugin extends AbstractPlugin implements ProductAbstractPluginCreateInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @see \Spryker\Zed\Product\ProductDependencyProvider

     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function create(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $this->getFacade()->persistProductAbstractAllowedQuantity($productAbstractTransfer);
    }
}
