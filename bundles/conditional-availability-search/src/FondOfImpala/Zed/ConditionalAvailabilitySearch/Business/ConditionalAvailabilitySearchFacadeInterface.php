<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business;

use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;

interface ConditionalAvailabilitySearchFacadeInterface
{
    /**
     * Specification:
     *  - Expand product page transfer with conditional availability data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $loadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $loadTransfer): ProductPageLoadTransfer;

    /**
     *  Specification:
     *  - Maps ConditionalAvailability data to ConditionalAvailabilityMapTransfer.
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer $conditionalAvailabilityMapTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer
     */
    public function mapProductDataToConditionalAvailabilityMapTransfer(
        array $productData,
        ConditionalAvailabilityMapTransfer $conditionalAvailabilityMapTransfer
    ): ConditionalAvailabilityMapTransfer;


    /**
     * Specification:
     * - Expands ProductConcretePageSearchTransfer with conditional availabilities data and returns the modified object.
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
}
