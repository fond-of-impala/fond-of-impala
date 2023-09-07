<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business;

use Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;

interface ConditionalAvailabilitySearchFacadeInterface
{
    /**
     * Specification:
     *  - Retrieve list of abstract product ids by concrete product ids.
     *
     * @api
     *
     * @param array<int> $concreteIds
     *
     * @return array<int>
     */
    public function getProductAbstractIdsByConcreteIds(array $concreteIds): array;

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
     * Specification:
     * - Expands ProductConcretePageSearchTransfer with stock status data and returns the modified object.
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
