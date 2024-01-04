<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade;

use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

interface AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer
     */
    public function findProductAbstractAllowedQuantity(
        ProductAbstractTransfer $productAbstractTransfer
    ): AllowedProductQuantityResponseTransfer;

    /**
     * @param array<string> $abstractSkus
     *
     * @return array<string, \Generated\Shared\Transfer\AllowedProductQuantityTransfer>
     */
    public function findGroupedProductAbstractAllowedQuantitiesByAbstractSkus(array $abstractSkus): array;
}
