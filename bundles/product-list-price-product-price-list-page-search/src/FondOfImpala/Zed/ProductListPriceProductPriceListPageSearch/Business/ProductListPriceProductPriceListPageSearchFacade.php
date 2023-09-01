<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchBusinessFactory getFactory()
 */
class ProductListPriceProductPriceListPageSearchFacade extends AbstractFacade implements
    ProductListPriceProductPriceListPageSearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function expandPriceProductAbstractPriceListPageSearchWithProductLists(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer {
        return $this->getFactory()
            ->createPriceProductAbstractPriceListPageSearchExpander()
            ->expandWithProductLists($priceProductPriceListPageSearchTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function expandPriceProductConcretePriceListPageSearchWithProductLists(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer {
        return $this->getFactory()
            ->createPriceProductConcretePriceListPageSearchExpander()
            ->expandWithProductLists($priceProductPriceListPageSearchTransfer);
    }
}
