<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\ProductPageSearchExtension;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductPageDataExpanderPluginInterface;

class GroupHashProductPageDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderPluginInterface
{
 /**
  * @param array $productData
  * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
  *
  * @return void
  */
    public function expandProductPageData(
        array $productData,
        ProductPageSearchTransfer $productAbstractPageSearchTransfer
    ): void {
        if (!isset($productData['SpyProductAbstract']['group_hash'])) {
            return;
        }

        $productAbstractPageSearchTransfer->setGroupHash($productData['SpyProductAbstract']['group_hash']);
    }
}
