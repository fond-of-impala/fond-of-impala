<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\ProductImageGroupingProductPageSearchBusinessFactory getFactory()
 */
class ProductImageGroupingProductPageSearchFacade extends AbstractFacade implements ProductImageGroupingProductPageSearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageSearchTransfer
     */
    public function groupProductImageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): ProductPageSearchTransfer
    {
        return $this->getFactory()->createProductImageGroupPageDataExpander()->expandProductPageData($productData, $productAbstractPageSearchTransfer);
    }
}
