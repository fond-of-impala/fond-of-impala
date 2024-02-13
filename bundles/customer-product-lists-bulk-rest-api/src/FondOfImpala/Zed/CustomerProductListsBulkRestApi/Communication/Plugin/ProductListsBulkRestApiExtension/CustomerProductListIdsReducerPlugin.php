<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\ProductListIdsReducerPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence\CustomerProductListsBulkRestApiRepositoryInterface getRepository()()
 */
class CustomerProductListIdsReducerPlugin extends AbstractPlugin implements ProductListIdsReducerPluginInterface
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
    ): array {
        $customerReference = $restProductListsBulkRequestTransfer->getCustomerReference();

        if ($customerReference === null) {
            return [];
        }

        $ownedProductListIds = $this->getRepository()->getProductListIdsByCustomerReference($customerReference);
        $reducedProductListIds = [];

        foreach ($productListIds as $key => $productListId) {
            if (!in_array($productListId, $ownedProductListIds, true)) {
                continue;
            }

            $reducedProductListIds[$key] = $productListId;
        }

        return $reducedProductListIds;
    }
}
