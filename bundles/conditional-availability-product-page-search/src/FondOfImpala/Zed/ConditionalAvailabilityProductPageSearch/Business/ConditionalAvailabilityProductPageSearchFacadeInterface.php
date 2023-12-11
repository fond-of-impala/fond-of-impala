<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business;

use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;

interface ConditionalAvailabilityProductPageSearchFacadeInterface
{
    /**
     * Specification:
     *  - Expand product page transfer with stock status data
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $loadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $loadTransfer): ProductPageLoadTransfer;

    /**
     * Specification:
     * - Expands ProductConcretePageSearchTransfer with stock status data
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expandProductConcretePageSearchTransferWithStockStatus(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer;

    /**
     * Specification:
     * - Trigger concrete and abstract products with periods that starts today
     *
     * @api
     *
     * @return void
     */
    public function triggerStockStatus(): void;

    /**
     * Specification:
     * - Trigger concrete and abstract products by stock status delta
     *
     * @api
     *
     * @return void
     */
    public function triggerStockStatusDelta(): void;
}
