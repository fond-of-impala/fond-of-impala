<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business;

use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchBusinessFactory getFactory()
 */
class ConditionalAvailabilityProductPageSearchFacade extends AbstractFacade implements ConditionalAvailabilityProductPageSearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $loadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $loadTransfer): ProductPageLoadTransfer
    {
        return $this->getFactory()->createProductPageDataExpander()->expandProductPageData($loadTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expandProductConcretePageSearchTransferWithStockStatus(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer {
        return $this->getFactory()
            ->createProductConcretePageSearchExpander()
            ->expandProductConcretePageSearchTransferWithStockStatus($productConcretePageSearchTransfer);
    }
}
