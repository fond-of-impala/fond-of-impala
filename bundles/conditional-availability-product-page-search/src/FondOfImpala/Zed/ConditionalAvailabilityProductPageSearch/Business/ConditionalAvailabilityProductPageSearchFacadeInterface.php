<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business;

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
