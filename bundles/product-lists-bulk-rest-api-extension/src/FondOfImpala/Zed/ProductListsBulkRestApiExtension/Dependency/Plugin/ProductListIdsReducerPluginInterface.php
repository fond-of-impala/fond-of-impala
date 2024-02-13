<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

interface ProductListIdsReducerPluginInterface
{
    /**
     * @param array<string, int> $productListIds
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return array<string, int>
     */
    public function reduce(
        array $productListIds,
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): array;
}
