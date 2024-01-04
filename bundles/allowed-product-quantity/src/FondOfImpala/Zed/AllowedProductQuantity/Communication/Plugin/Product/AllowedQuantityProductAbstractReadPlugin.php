<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Communication\Plugin\Product;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginReadInterface;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\AllowedProductQuantityConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface getFacade()
 */
class AllowedQuantityProductAbstractReadPlugin extends AbstractPlugin implements ProductAbstractPluginReadInterface
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
    public function read(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        $allowedProductQuantityResponseTransfer = $this->getFacade()
            ->findProductAbstractAllowedQuantity($productAbstractTransfer);

        if (!$allowedProductQuantityResponseTransfer->getIsSuccessful()) {
            return $productAbstractTransfer;
        }

        return $productAbstractTransfer->setAllowedQuantity(
            $allowedProductQuantityResponseTransfer->getAllowedProductQuantityTransfer(),
        );
    }
}
