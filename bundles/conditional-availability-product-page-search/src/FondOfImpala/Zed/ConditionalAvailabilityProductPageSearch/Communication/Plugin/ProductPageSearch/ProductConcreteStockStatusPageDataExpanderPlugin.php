<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch;

use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductConcretePageDataExpanderPluginInterface;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacadeInterface getFacade()
 */
class ProductConcreteStockStatusPageDataExpanderPlugin extends AbstractPlugin implements ProductConcretePageDataExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands provided ProductConcretePageSearchTransfer with stock status.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expand(
        ProductConcreteTransfer $productConcreteTransfer,
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer {
        $productConcretePageSearchTransfer->setFkProduct($productConcreteTransfer->getIdProductConcrete());

        return $this->getFacade()
            ->expandProductConcretePageSearchTransferWithStockStatus($productConcretePageSearchTransfer);
    }
}
