<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\ProductPageSearch\DataExpander;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

class ConditionalAvailabilitytDataLoadExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    /**
     * @param array $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer)
    {
        // TODO: Implement expandProductPageData() method.
    }
}
